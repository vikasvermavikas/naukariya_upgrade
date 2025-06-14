<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Webklex\IMAP\Facades\Client;
use Illuminate\Support\Facades\Log;


class GetEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get resumes from mail through IMAP';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ini_set('max_execution_time', 180);
        // Get default account configuration.
        $client = Client::account('default');
        $client->connect();  // Connect to account

        // Check whether account is connected or not
        $status = $client->isConnected();
        if ($status) {
            $folder = $client->getFolderByName('INBOX');
            $query = $folder->messages();
            $query->markAsRead();
            $query->setFetchOrder("desc");
            $messages = $query->since(\Carbon\Carbon::now()->subDays(1))->unseen()->get();
            if ($messages && count($messages) > 0) {
                $i = 0;
                foreach ($messages as $message) {
                    if ($message->hasAttachments()) {
                        $attachments = $message->getAttachments();
                        foreach ($attachments as $attachment) {
                            $status = $attachment->save(public_path() . '/mail_attachments/', $filename = time() . "_" . $i . "." . $attachment->getExtension());
                            store_attachment([
                                'date' => $message->date,
                                'filename' => $attachment->name,
                                'stored_file' => $filename,
                                'download_status' => $status ? 'downloaded' : null
                            ]);
                            $i++;
                        }
                    } else {
                        continue;
                    }
                    Log::info('Attachment download successfully.');

                }
            }
            else {
                Log::info('Messages not available.');
            }
        } else {
            Log::info('Gmail connection disconnected.');
        }
    }
}
