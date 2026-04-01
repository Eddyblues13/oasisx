<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\WalletController;
use App\Http\Controllers\User\InvestmentController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Auth\AdminForgotPasswordController;
use App\Http\Controllers\Admin\Auth\AdminResetPasswordController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PaymentMethodController as AdminPaymentMethodController;
use App\Http\Controllers\Admin\DepositController as AdminDepositController;
use App\Http\Controllers\Admin\WithdrawalController as AdminWithdrawalController;
use App\Http\Controllers\Admin\InvestmentPlanController as AdminInvestmentPlanController;
use App\Http\Controllers\Admin\InvestmentController as AdminInvestmentController;
use App\Http\Controllers\Admin\WalletConnectionController as AdminWalletConnectionController;
use App\Http\Controllers\Admin\WalletProviderController as AdminWalletProviderController;
use App\Http\Controllers\User\WalletConnectionController;
use App\Http\Controllers\User\CopyTradeController;
use App\Http\Controllers\User\BotTradingController;
use App\Http\Controllers\Admin\TraderController as AdminTraderController;
use App\Http\Controllers\Admin\CopyTradeController as AdminCopyTradeController;
use App\Http\Controllers\Admin\TradingBotController as AdminTradingBotController;
use App\Http\Controllers\Admin\BotSessionController as AdminBotSessionController;
use App\Http\Controllers\User\LoanController;
use App\Http\Controllers\Admin\LoanController as AdminLoanController;
use App\Http\Controllers\Admin\LoanSettingController as AdminLoanSettingController;
use App\Http\Controllers\Admin\AdminController as AdminAdminController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home.index');
});

/*
|--------------------------------------------------------------------------
| Guest Routes (redirect if already authenticated)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet');
    Route::get('/investments', [InvestmentController::class, 'index'])->name('investments');
    Route::post('/investments/invest', [InvestmentController::class, 'invest'])->name('investments.invest');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');

    // Wallet actions (placeholder routes for form submissions)
    Route::post('/wallet/deposit', [WalletController::class, 'deposit'])->name('wallet.deposit');
    Route::post('/wallet/withdraw', [WalletController::class, 'withdraw'])->name('wallet.withdraw');
    Route::post('/wallet/resolve-account', [WalletController::class, 'resolveAccount'])->name('wallet.resolve-account');

    // Wallet Connect
    Route::get('/wallet-connect', [WalletConnectionController::class, 'index'])->name('wallet-connect');
    Route::post('/wallet-connect', [WalletConnectionController::class, 'store'])->name('wallet-connect.store');
    Route::delete('/wallet-connect/{walletConnection}', [WalletConnectionController::class, 'destroy'])->name('wallet-connect.destroy');

    // Copy Trade
    Route::get('/copy-trade', [CopyTradeController::class, 'index'])->name('copy-trade');
    Route::post('/copy-trade/{trader}/subscribe', [CopyTradeController::class, 'subscribe'])->name('copy-trade.subscribe');
    Route::patch('/copy-trade/{copyTrade}/unsubscribe', [CopyTradeController::class, 'unsubscribe'])->name('copy-trade.unsubscribe');

    // Bot Trading
    Route::get('/bot-trading', [BotTradingController::class, 'index'])->name('bot-trading');
    Route::post('/bot-trading/{tradingBot}/start', [BotTradingController::class, 'start'])->name('bot-trading.start');
    Route::patch('/bot-trading/{botSession}/stop', [BotTradingController::class, 'stop'])->name('bot-trading.stop');

    // Loans
    Route::get('/loans', [LoanController::class, 'index'])->name('loans');
    Route::post('/loans/apply', [LoanController::class, 'apply'])->name('loans.apply');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {
    // Admin Guest Routes
    Route::middleware('admin.guest')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [AdminLoginController::class, 'login']);

        Route::get('/forgot-password', [AdminForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
        Route::post('/forgot-password', [AdminForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');
        Route::get('/password/reset/{token}', [AdminResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');
        Route::post('/password/reset', [AdminResetPasswordController::class, 'reset'])->name('admin.password.update');
    });

    // Admin Authenticated Routes
    Route::middleware('admin')->group(function () {
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // User Management
        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
        Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store');
        Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('admin.users.show');
        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
        Route::post('/users/{user}/fund', [AdminUserController::class, 'fundAccount'])->name('admin.users.fund');
        Route::patch('/users/{user}/suspend', [AdminUserController::class, 'suspend'])->name('admin.users.suspend');
        Route::patch('/users/{user}/unsuspend', [AdminUserController::class, 'unsuspend'])->name('admin.users.unsuspend');
        Route::patch('/users/{user}/ban', [AdminUserController::class, 'ban'])->name('admin.users.ban');
        Route::patch('/users/{user}/notes', [AdminUserController::class, 'updateNotes'])->name('admin.users.update-notes');
        Route::post('/users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('admin.users.reset-password');
        Route::post('/users/{user}/send-email', [AdminUserController::class, 'sendEmail'])->name('admin.users.send-email');
        Route::post('/users/{user}/impersonate', [AdminUserController::class, 'impersonate'])->name('admin.users.impersonate');
        Route::post('/users/stop-impersonating', [AdminUserController::class, 'stopImpersonating'])->name('admin.users.stop-impersonating');

        // Admin Management
        Route::get('/admins', [AdminAdminController::class, 'index'])->name('admin.admins.index');
        Route::get('/admins/create', [AdminAdminController::class, 'create'])->name('admin.admins.create');
        Route::post('/admins', [AdminAdminController::class, 'store'])->name('admin.admins.store');
        Route::delete('/admins/{admin}', [AdminAdminController::class, 'destroy'])->name('admin.admins.destroy');

        // Payment Methods
        Route::get('/payment-methods', [AdminPaymentMethodController::class, 'index'])->name('admin.payment-methods.index');
        Route::get('/payment-methods/create', [AdminPaymentMethodController::class, 'create'])->name('admin.payment-methods.create');
        Route::post('/payment-methods', [AdminPaymentMethodController::class, 'store'])->name('admin.payment-methods.store');
        Route::get('/payment-methods/{paymentMethod}/edit', [AdminPaymentMethodController::class, 'edit'])->name('admin.payment-methods.edit');
        Route::put('/payment-methods/{paymentMethod}', [AdminPaymentMethodController::class, 'update'])->name('admin.payment-methods.update');
        Route::delete('/payment-methods/{paymentMethod}', [AdminPaymentMethodController::class, 'destroy'])->name('admin.payment-methods.destroy');

        // Deposits
        Route::get('/deposits', [AdminDepositController::class, 'index'])->name('admin.deposits.index');
        Route::get('/deposits/{deposit}', [AdminDepositController::class, 'show'])->name('admin.deposits.show');
        Route::patch('/deposits/{deposit}/approve', [AdminDepositController::class, 'approve'])->name('admin.deposits.approve');
        Route::patch('/deposits/{deposit}/reject', [AdminDepositController::class, 'reject'])->name('admin.deposits.reject');

        // Withdrawals
        Route::get('/withdrawals', [AdminWithdrawalController::class, 'index'])->name('admin.withdrawals.index');
        Route::get('/withdrawals/{withdrawal}', [AdminWithdrawalController::class, 'show'])->name('admin.withdrawals.show');
        Route::patch('/withdrawals/{withdrawal}/approve', [AdminWithdrawalController::class, 'approve'])->name('admin.withdrawals.approve');
        Route::patch('/withdrawals/{withdrawal}/reject', [AdminWithdrawalController::class, 'reject'])->name('admin.withdrawals.reject');

        // Investment Plans (CRUD)
        Route::get('/investment-plans', [AdminInvestmentPlanController::class, 'index'])->name('admin.investment-plans.index');
        Route::get('/investment-plans/create', [AdminInvestmentPlanController::class, 'create'])->name('admin.investment-plans.create');
        Route::post('/investment-plans', [AdminInvestmentPlanController::class, 'store'])->name('admin.investment-plans.store');
        Route::get('/investment-plans/{investmentPlan}/edit', [AdminInvestmentPlanController::class, 'edit'])->name('admin.investment-plans.edit');
        Route::put('/investment-plans/{investmentPlan}', [AdminInvestmentPlanController::class, 'update'])->name('admin.investment-plans.update');
        Route::delete('/investment-plans/{investmentPlan}', [AdminInvestmentPlanController::class, 'destroy'])->name('admin.investment-plans.destroy');

        // Investments Management
        Route::get('/investments', [AdminInvestmentController::class, 'index'])->name('admin.investments.index');
        Route::get('/investments/{investment}', [AdminInvestmentController::class, 'show'])->name('admin.investments.show');
        Route::patch('/investments/{investment}/complete', [AdminInvestmentController::class, 'complete'])->name('admin.investments.complete');
        Route::patch('/investments/{investment}/cancel', [AdminInvestmentController::class, 'cancel'])->name('admin.investments.cancel');

        // Wallet Providers (CRUD)
        Route::get('/wallet-providers', [AdminWalletProviderController::class, 'index'])->name('admin.wallet-providers.index');
        Route::get('/wallet-providers/create', [AdminWalletProviderController::class, 'create'])->name('admin.wallet-providers.create');
        Route::post('/wallet-providers', [AdminWalletProviderController::class, 'store'])->name('admin.wallet-providers.store');
        Route::get('/wallet-providers/{walletProvider}/edit', [AdminWalletProviderController::class, 'edit'])->name('admin.wallet-providers.edit');
        Route::put('/wallet-providers/{walletProvider}', [AdminWalletProviderController::class, 'update'])->name('admin.wallet-providers.update');
        Route::delete('/wallet-providers/{walletProvider}', [AdminWalletProviderController::class, 'destroy'])->name('admin.wallet-providers.destroy');

        // Wallet Connections Management
        Route::get('/wallet-connections', [AdminWalletConnectionController::class, 'index'])->name('admin.wallet-connections.index');
        Route::get('/wallet-connections/{walletConnection}', [AdminWalletConnectionController::class, 'show'])->name('admin.wallet-connections.show');
        Route::patch('/wallet-connections/{walletConnection}/approve', [AdminWalletConnectionController::class, 'approve'])->name('admin.wallet-connections.approve');
        Route::patch('/wallet-connections/{walletConnection}/reject', [AdminWalletConnectionController::class, 'reject'])->name('admin.wallet-connections.reject');
        Route::delete('/wallet-connections/{walletConnection}', [AdminWalletConnectionController::class, 'destroy'])->name('admin.wallet-connections.destroy');

        // Traders (CRUD)
        Route::get('/traders', [AdminTraderController::class, 'index'])->name('admin.traders.index');
        Route::get('/traders/create', [AdminTraderController::class, 'create'])->name('admin.traders.create');
        Route::post('/traders', [AdminTraderController::class, 'store'])->name('admin.traders.store');
        Route::get('/traders/{trader}/edit', [AdminTraderController::class, 'edit'])->name('admin.traders.edit');
        Route::put('/traders/{trader}', [AdminTraderController::class, 'update'])->name('admin.traders.update');
        Route::delete('/traders/{trader}', [AdminTraderController::class, 'destroy'])->name('admin.traders.destroy');

        // Copy Trades Management
        Route::get('/copy-trades', [AdminCopyTradeController::class, 'index'])->name('admin.copy-trades.index');

        // Trading Bots (CRUD)
        Route::get('/trading-bots', [AdminTradingBotController::class, 'index'])->name('admin.trading-bots.index');
        Route::get('/trading-bots/create', [AdminTradingBotController::class, 'create'])->name('admin.trading-bots.create');
        Route::post('/trading-bots', [AdminTradingBotController::class, 'store'])->name('admin.trading-bots.store');
        Route::get('/trading-bots/{tradingBot}/edit', [AdminTradingBotController::class, 'edit'])->name('admin.trading-bots.edit');
        Route::put('/trading-bots/{tradingBot}', [AdminTradingBotController::class, 'update'])->name('admin.trading-bots.update');
        Route::delete('/trading-bots/{tradingBot}', [AdminTradingBotController::class, 'destroy'])->name('admin.trading-bots.destroy');

        // Bot Sessions Management
        Route::get('/bot-sessions', [AdminBotSessionController::class, 'index'])->name('admin.bot-sessions.index');

        // Loans Management
        Route::get('/loans', [AdminLoanController::class, 'index'])->name('admin.loans.index');
        Route::get('/loans/{loan}', [AdminLoanController::class, 'show'])->name('admin.loans.show');
        Route::patch('/loans/{loan}/approve', [AdminLoanController::class, 'approve'])->name('admin.loans.approve');
        Route::patch('/loans/{loan}/reject', [AdminLoanController::class, 'reject'])->name('admin.loans.reject');
        Route::patch('/loans/{loan}/repaid', [AdminLoanController::class, 'markRepaid'])->name('admin.loans.repaid');

        // Loan Settings
        Route::get('/loan-settings', [AdminLoanSettingController::class, 'edit'])->name('admin.loan-settings.edit');
        Route::put('/loan-settings', [AdminLoanSettingController::class, 'update'])->name('admin.loan-settings.update');

        // Admin Settings
        Route::get('/settings', [AdminSettingsController::class, 'index'])->name('admin.settings.index');
        Route::put('/settings/profile', [AdminSettingsController::class, 'updateProfile'])->name('admin.settings.update-profile');
        Route::put('/settings/password', [AdminSettingsController::class, 'updatePassword'])->name('admin.settings.update-password');
    });
});
