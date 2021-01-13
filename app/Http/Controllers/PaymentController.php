<?php

namespace App\Http\Controllers;

use App\Models\NotaVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Exception\PayPalConnectionException;

class PaymentController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $PaypalConfig = Config::get('paypal');

        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $PaypalConfig['client_id'],
                $PaypalConfig['secret']
            )
        );
    }

    public function PayWithPaypal(Request $request)
    {
        $pago = $request->pago;
        $user_id = $request->user_id;
        $foto_id = $request->id_foto;

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal($pago);
        $amount->setCurrency('USD');

        $transaction = new Transaction();
        $transaction->setAmount($amount);

        $redirectUrls = new RedirectUrls();

        $correctUrl = url('/buy/verfy/' . $user_id . '/' . $foto_id . '/' . $pago);
        $errorUrl = url('/buy/error');

        $redirectUrls->setReturnUrl($correctUrl)
            ->setCancelUrl($errorUrl);

        $payment = new Payment();

        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);

        try {

            $payment->create($this->apiContext);

            return redirect()->away($payment->getApprovalLink());
        } catch (PayPalConnectionException $e) {

            return redirect()->route('buy.error');
        }
    }

    public function BuyVerify(Request $request, $user_id, $foto_id, $pago)
    {
        $paymentId = $request->input('paymentId');
        $token = $request->input('token');
        $payerId = $request->input('PayerID');

        if (!$paymentId || !$token || !$payerId) {
            return redirect()->route('buy.error');
        }

        $payment = Payment::get($paymentId, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        $result = $payment->execute($execution, $this->apiContext);

        if ($result->getState() === "approved") {

            $notaventa = [
                'fecha' => date('Y-m-d'),
                'total' => $pago,
                'id_foto' => $foto_id,
                'id_usuario' => $user_id
            ];

            NotaVenta::create($notaventa);

            return redirect()->route('buy.correct');

        }

        return redirect()->route('buy.error');
    }

    public function BuyError()
    {
        return view('paypal.errorBuy');
    }

    public function BuyCorrect()
    {
        return View('paypal.correctBuy');
    }
}
