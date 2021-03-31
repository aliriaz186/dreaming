<?php

namespace services\email_messages;

class InvitationMessageBody
{
    public function invitationMessageBody($id)
    {
        $emailBody = '
   <body>
             <div style="margin-left: 50px;font-size: 25px;padding-top: 40px">Welcome to Dreaming!</div><br>
             <div style="margin-left: 50px;font-size: 25px;padding-top: 40px">Thankyou for your subscripton. You can translate unlimited dreams now! You can unsubscribe anytime by clicking the below button</div><br>
 <div style="padding-top: 30px;padding-bottom: 40px">
 <a href="'. url('unsubscribe'). '/'.$id.'" style=" background-color: maroon;
  border: none;
  color: white;
  padding: 10px 27px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 18px;
  cursor: pointer;
  border-radius: 3px;margin-left: 50px">UNSUBSCRIBE</a>
  </div>
            </body>
            ';
        return $emailBody;
    }

}
