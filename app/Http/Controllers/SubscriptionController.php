<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
Use App\Models\User;
use App\Models\Plan;


class SubscriptionController extends Controller
{
    protected $stripe;

    public function __construct() 
    {
        $this->stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    }

    // public function index()
    // {   
    //     return view('subscription.create');
    // }

    // public function showStripe(){

    //     // $stripe = array(
    //     //     "secret_key" => "sk_test_51IlK6HDoULpDRQsxvnaIQ4mSksoxJwlTMfAcxmpOUnWmuODvX8MWQkcKildVidhh9Cb8c4XRWvIvlmA2DYjozWoK00E5m9lbdk",
    //     //     "publishable_key" => "pk_test_51IlK6HDoULpDRQsxvdiYU36lTSr9IQPbB02j2UmN6CJsSrSEDrnhygBvU5IBbIXCN0uoSFOoXJXAOEcxdYcgHs6O00QWoRkBLC"
    //     //     ); // Test keys

        

    //     $stripe = new \Stripe\StripeClient(env("STRIPE_SECRET"));
        
    //     $rs = $stripe->prices->retrieve(
    //         'price_1Jm35ADoULpDRQsxBpN21tA7',
    //         []
    //       );

    //       return $rs;
    //     $user = auth()->user();

    //     $dataActive = $stripe->subscriptions->all(['customer' => $user->stripe_id]);

    //     return view('subscription.index',compact('dataActive'));
    // }

    // public function orderPost(Request $request)
    // {
    //         $user = auth()->user();
    //         $input = $request->all();
    //         $token =  $request->stripeToken;
    //         $paymentMethod = $request->paymentMethod;
    //         try {
                

    //             Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                
    //             if (is_null($user->stripe_id)) {
    //                 $stripeCustomer = $user->createAsStripeCustomer();
    //             }

    //             \Stripe\Customer::createSource(
    //                 $user->stripe_id,
    //                 ['source' => $token]
    //             );

    //             $user->newSubscription('test',$input['plane'])
    //                 ->create($paymentMethod, [
    //                 'email' => $user->email,
    //             ]);

    //             return back()->with('success','Subscription is completed.');
    //         } catch (Exception $e) {
    //             return back()->with('success',$e->getMessage());
    //         }
            
    // }


    public function create(Request $request, Plan $plan)
    {
        $plan = Plan::findOrFail($request->get('plan'));
        
        $user = $request->user();
        $paymentMethod = $request->paymentMethod;

        $user->createOrGetStripeCustomer();
        $user->updateDefaultPaymentMethod($paymentMethod);
        $user->newSubscription('default', $plan->stripe_plan)
            ->create($paymentMethod, [
                'email' => $user->email,
            ]);
        
        return redirect()->route('home')->with('success', 'Your plan subscribed successfully');
    }


    public function createPlan()
    {
        return view('plans.create');
    }

    public function storePlan(Request $request)
    {   
        $data = $request->except('_token');

        $data['slug'] = strtolower($data['name']);
        $price = $data['cost'] *100; 

        //create stripe product
        $stripeProduct = $this->stripe->products->create([
            'name' => $data['name'],
        ]);
        
        //Stripe Plan Creation
        $stripePlanCreation = $this->stripe->plans->create([
            'amount' => $price,
            'currency' => 'inr',
            'interval' => 'month', //  it can be day,week,month or year
            'product' => $stripeProduct->id,
        ]);

        $data['stripe_plan'] = $stripePlanCreation->id;

        Plan::create($data);

        echo 'plan has been created';
    }
}