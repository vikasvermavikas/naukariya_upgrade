<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class ChatBotController extends Controller
{
    public function index(Request $request) {
        $query = $request['query'];

        if($query == 'Yes' || $query == 'yes') {
            return '<span class="chat_msg_item"><div class="chat_avatar"><img src="https://cdn.iconscout.com/icon/premium/png-512-thumb/chatbot-1876975-1589760.png"/></div><span class="chat_msg_item chat_msg_item_admin">Select your query</span><ul class="tags"><li class="queryTxtRes">How does naukriyan work?</li> <li class="queryTxtRes">Why should I register with naukriyan.com?</li> <li class="queryTxtRes">How do I register on naukriyan.com?</li> <li class="queryTxtRes">Does it cost to create a naukriyan profile?</li> <li class="queryTxtRes">How can I update/edit my Profile?</li> <li class="queryTxtRes">Other</li></ul></span>';
        }

        if($query == 'No' || $query == 'no') {
            return 'Thank you';
        }   

        $chatResponse = DB::table('chatbot')->where('queries', $query)->first();

        if(!$chatResponse) {
            return 'Sorry can not be able to understand you!';
        }

        return $chatResponse->replies;
    }   
}
