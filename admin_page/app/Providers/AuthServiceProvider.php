<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Order;
use App\Product;
use App\ProductDiscount;
use App\ProductFormat;
use App\TimeBlock;
use App\User;
use App\Policies\OrderPolicy;
use App\Policies\ProductPolicy;
use App\Policies\ProductDiscountPolicy;
use App\Policies\ProductFormatPolicy;
use App\Policies\TimeBlockPolicy;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Order::class => OrderPolicy::class,
        Product::class => ProductPolicy::class,
        ProductDiscount::class => ProductDiscountPolicy::class,
        ProductFormat::class => ProductFormatPolicy::class,
        TimeBlock::class => TimeBlockPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
