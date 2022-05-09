<?php

namespace Modules\Wallet\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class WalletBalance extends Model
{
    use HasFactory;
    protected $table = 'wallet_balances';
    protected $guarded = ['id'];

    public function walletable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item_details()
    {
        return $this->morphMany(BankPayment::class, 'itemable');
    }

    public function getGatewayNameAttribute()
    {
        switch ($this->payment_method) {
            case '1':
                return "Cash On Delivery";
                break;
            case '2':
                return "Wallet";
                break;
            case '3':
                return "PayPal";
                break;
            case '4':
                return "Stripe";
                break;
            case '5':
                return "PayStack";
                break;
            case '6':
                return "RazorPay";
                break;
            case '7':
                return "Bank Payment";
                break;
            case '8':
                return "Instamojo";
                break;
            case '9':
                return "PayTM";
                break;
            case '10':
                return "Midtrans";
                break;
            case '11':
                return "PayUMoney";
                break;
            case '12':
                return "JazzCash";
                break;
            case '13':
                return "Google Pay";
                break;
            case '14':
                return "FlutterWave";
                break;
            default:
                return $this->payment_method;
                break;
        }
    }
}
