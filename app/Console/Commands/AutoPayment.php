<?php

namespace App\Console\Commands;

use App\dreams;
use App\PaymentHistory;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Session;

class AutoPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto Payment of customers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::all();
        foreach ($users as $user){
            $time = strtotime($user->last_payment);
            $final = date("Y-m-d", strtotime("+1 month", $time));
           if( date('Y-m-d') >= $final && $user->active != 0){

               try {
                   $stripe = \Cartalyst\Stripe\Laravel\Facades\Stripe::setApiKey(env('STRIPE_SECRET'));
                   $token = $stripe->tokens()->create([
                       'card' => [
                           'number' => $user->card,
                           'exp_month' => $user->exp_month,
                           'exp_year' => $user->exp_year,
                           'cvc' => $user->cvv,
                       ],
                   ]);

                   if (!isset($token['id'])) {
                       //error
                       $user->active = 2;
                       $user->update();
                   }



                   $charge = $stripe->charges()->create([
                       'card' => $token['id'],
                       'currency' => 'USD',
                       'amount' => 10,
                       'description' => 'wallet',
                   ]);

                   if ($charge['status'] == 'succeeded') {
                       $user->last_payment = date('Y-m-d');
                       $user->update();


                       $paymentHistory = new PaymentHistory();
                       $paymentHistory->user_id = $user->id;
                       $paymentHistory->amount = 10;
                       $paymentHistory->date = date('Y-m-d');
                       $paymentHistory->save();


                   } else {
                       $user->active = 2;
                       $user->update();

                   }
               }catch (\Exception $exception){
                   $user->active = 2;
                   $user->update();
               }

           }

        }

        $this->info('Auto Payment Completed');
    }
}
