<?php

use App\Http\Controllers\ChasePaymentController;
use App\Models\Order;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\SquareController;
use App\Http\Controllers\AuthorizenetController;
use App\Http\Controllers\RapydController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\BriefFormController;
use App\Http\Controllers\BriefPortalController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\returnArgument;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/order-agreement', function () {
    $order = Order::find(46);
    return view('mails.payment_successful',compact('order'));
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
});

Route::get('/cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
});

// Auth::routes();
// Guest Routes
Route::group(['middleware' => ['guest:adminiy,user']], function () {

    Route::get("admin/login", [LoginController::class, 'login'])->name('admin.login');

    Route::post("admin/login", [LoginController::class, 'login_process'])->name('admin.login.process');

    Route::get("user/login", [UserController::class, 'login'])->name('user.login');

    Route::post("user/login", [UserController::class, 'login_process'])->name('user.login.process');
});

// Route::get('/generate-link',[HomeController::class,'index'])->name('home');
Route::get('/order/create', [OrderController::class, 'create_order'])
    ->middleware('permission:create_payment_link')->name('home');

Route::post('/brand_packages', [HomeController::class, 'brand_packages'])->name('brand.merchant.packages');

Route::get('order/create', [OrderController::class, 'create_order'])
    ->middleware('permission:create_payment_link')->name('payment.create_order');

Route::post('order_submit', [OrderController::class, 'order_store'])
    ->middleware('permission:create_payment_link')->name('order.submit');

Route::get('{brander}/order/{link}', [OrderController::class, 'payment_terminal'])->name('payment.terminal');

Route::post('payout', [OrderController::class, 'payout'])->name('payout');

Route::get('thanks/{oi?}', [OrderController::class, 'thanks'])->name('thanks');

// A private, expiring email link signs the client in and opens the requested brief.
Route::get('brief/access/{token}', [BriefPortalController::class, 'access'])
    ->middleware('throttle:20,1')->name('brief.access');
Route::get('client/dashboard', [BriefPortalController::class, 'dashboard'])->name('client.brief.dashboard');
Route::get('client/brief/{id}', [BriefPortalController::class, 'showForm'])->name('client.brief.show');
Route::post('client/brief/{id}', [BriefPortalController::class, 'submit'])
    ->middleware('throttle:10,1')->name('client.brief.submit');

Route::post('stripe_checkout', [StripeController::class, 'stripe_checkout'])->name('stripe.checkout');

Route::post('chase_checkout', [ChasePaymentController::class, 'chasePayment'])->name('chase.checkout');

Route::post('square_checkout', [SquareController::class, 'checkout_square'])->name('square.checkout');

Route::post('authorizenet_checkout', [AuthorizenetController::class, 'handleonlinepay'])->name('authorizenet.checkout');

Route::post('rapyd_checkout', [RapydController::class, 'checkout_rapyd'])->name('rapyd.checkout');

Route::get('rapyd_response/{data}', [RapydController::class, 'get_response'])->name('rapyd.response');

Route::put('orders/request-payment-link/{id}', [OrderController::class, 'request_payment_link'])->name('orders.request_payment_link');

Route::post('signature/save', [OrderController::class, 'signatureSave'])->name('signature.save');

Route::group(['middleware' => ['admin']], function () {

    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    Route::get('chnage-password', [AdminController::class, 'chnage_password'])->name('admin.chnage_password');
    Route::post('update-password', [AdminController::class, 'update_password'])->name('admin.update_password');

    // ------------------------- Brands -------------------------
    Route::get('/brands', [BrandController::class, 'index'])
        ->middleware('permission:brand_view')->name('admin.brands.index');

    Route::get('brands/create', [BrandController::class, 'create'])
        ->middleware('permission:brand_create')->name('admin.brands.create');

    Route::post('brands/store', [BrandController::class, 'store'])
        ->middleware('permission:brand_create')->name('admin.brands.store');

    Route::get('brands/edit/{id}', [BrandController::class, 'edit'])
        ->middleware('permission:brand_edit')->name('admin.brands.edit');

    Route::post('brands/update/{id}', [BrandController::class, 'update'])
        ->middleware('permission:brand_edit')->name('admin.brands.update');

    Route::get('brands/destroy/{id}', [BrandController::class, 'destroy'])
        ->middleware('permission:brand_edit')->name('admin.brands.destroy');

    // ------------------------- Packages -------------------------
    Route::get('packages', [PackageController::class, 'index'])
        ->middleware('permission:packages_view')->name('packages');

    Route::get('packages/create', [PackageController::class, 'create'])
        ->middleware('permission:packages_create')->name('packages.create');

    Route::post('packages/store', [PackageController::class, 'store'])
        ->middleware('permission:packages_create')->name('packages.store');

    Route::get('packages/edit/{id}', [PackageController::class, 'edit'])
        ->middleware('permission:packages_edit')->name('packages.edit');

    Route::post('packages/update/{id}', [PackageController::class, 'update'])
        ->middleware('permission:packages_edit')->name('packages.update');

    Route::post('packages/update_all', [PackageController::class, 'update_all'])
        ->middleware('permission:packages_edit')->name('packages.update.all');

    Route::get('packages/destroy/{id}', [PackageController::class, 'destroy'])
        ->middleware('permission:packages_edit')->name('packages.destroy');

    Route::get('brand/packages/edit', [PackageController::class, 'brand_packages_edit'])
        ->middleware('permission:packages_edit')->name('brand.packages.edit');

    // ------------------------- Merchants -------------------------

    Route::get('merchants', [MerchantController::class, 'index'])
        ->middleware('permission:merchant_view')->name('merchant.index');

    Route::get('merchants/create', [MerchantController::class, 'create'])
        ->middleware('permission:merchant_create')->name('merchant.create');

    Route::post('merchants/store', [MerchantController::class, 'store'])
        ->middleware('permission:merchant_create')->name('merchant.store');

    Route::get('merchants/edit/{id}', [MerchantController::class, 'edit'])
        ->middleware('permission:merchant_edit')->name('merchant.edit');

    Route::post('merchants/update/{id}', [MerchantController::class, 'update'])
        ->middleware('permission:merchant_edit')->name('merchant.update');

    Route::get('merchants/destroy/{id}', [MerchantController::class, 'destroy'])
        ->middleware('permission:merchant_edit')->name('merchant.destroy');

    Route::get('brand/merchants/edit', [BrandController::class, 'brand_merchants_edit'])
        ->middleware('permission:merchant_view')->name('brand.merchants.edit');

    Route::post('merchants/update_all', [BrandController::class, 'update_all'])
        ->middleware('permission:merchant_edit')->name('merchants.update.all');

    Route::get('package/status/{id}', [PackageController::class, 'package_status_change'])
        ->middleware('permission:packages_edit')->name('package.status.change');

    // ------------------------- Orders -------------------------
    Route::get('orders', [OrderController::class, 'index'])
        ->middleware('permission:view_all_orders,view_only_his_order')->name('admin.orders.index');

    // Route::get('orders/own', [OrderController::class, 'ownOrders'])
    //     ->middleware('permission:view_only_his_order')->name('admin.orders.own');

    Route::get('orders/{email}', [OrderController::class, 'customer_orders'])
        ->middleware('permission:view_all_orders,view_only_his_order')->name('admin.customer.orders');

    Route::get('orders/create', [OrderController::class, 'create'])
        ->middleware('permission:view_all_orders')->name('admin.orders.create');

    Route::post('orders/store', [OrderController::class, 'store'])
        ->middleware('permission:view_all_orders')->name('admin.orders.store');

    Route::get('orders/show/{id}', [OrderController::class, 'show'])
        ->middleware('permission:view_all_orders,view_only_his_order')->name('admin.orders.show');

    Route::get('orders/edit/{id}', [OrderController::class, 'edit'])
        ->middleware('permission:view_all_orders')->name('admin.orders.edit');

    Route::post('orders/update/{id}', [OrderController::class, 'update'])
        ->middleware('permission:view_all_orders')->name('admin.orders.update');

    Route::get('orders/destroy/{id}', [OrderController::class, 'destroy'])
        ->middleware('permission:view_all_orders')->name('admin.orders.destroy');

    Route::get('orders/status/{id}/{status}', [OrderController::class, 'status'])
        ->middleware('permission:view_all_orders')->name('admin.orders.status');

    Route::get('invoices/{id}', [InvoiceController::class, 'index'])
        ->middleware('permission:view_all_orders,view_only_his_order')->name('admin.invoices.index');

    // ------------------------- Support (client assignment) -------------------------
    Route::post('orders/assign-support/{id}', [OrderController::class, 'assignSupport'])
        ->middleware('permission:assign_support_person')->name('admin.orders.assign_support');

    Route::get('assigned-clients', [OrderController::class, 'assignedClients'])
        ->middleware('permission:view_assigned_client')->name('admin.assigned_clients');

    Route::get('assigned-clients/orders/{id}', [OrderController::class, 'assignedOrderShow'])
        ->middleware('permission:view_assigned_client')->name('admin.assigned_order.show');

    Route::post('assigned-clients/{clientId}/brief-forms', [BriefFormController::class, 'sendToClient'])
        ->middleware('permission:send_brief_forms')->name('admin.brief_forms.send');

    Route::get('payment-links', [InvoiceController::class, 'paymentLinks'])
        ->middleware('permission:view_payment_link')->name('admin.payment_links');

    // ------------------------- Brief form templates and submissions -------------------------
    Route::get('brief-forms', [BriefFormController::class, 'index'])
        ->middleware('permission:manage_brief_forms')->name('admin.brief_forms.index');
    Route::post('brief-forms', [BriefFormController::class, 'store'])
        ->middleware('permission:manage_brief_forms')->name('admin.brief_forms.store');
    Route::get('brief-forms/{id}/edit', [BriefFormController::class, 'edit'])
        ->middleware('permission:manage_brief_forms')->name('admin.brief_forms.edit');
    Route::post('brief-forms/{id}/update', [BriefFormController::class, 'update'])
        ->middleware('permission:manage_brief_forms')->name('admin.brief_forms.update');
    Route::post('brief-forms/{id}/archive', [BriefFormController::class, 'archive'])
        ->middleware('permission:manage_brief_forms')->name('admin.brief_forms.archive');
    Route::post('brief-forms/{id}/fields', [BriefFormController::class, 'storeField'])
        ->middleware('permission:manage_brief_forms')->name('admin.brief_forms.fields.store');
    Route::post('brief-forms/{id}/fields/{fieldId}', [BriefFormController::class, 'updateField'])
        ->middleware('permission:manage_brief_forms')->name('admin.brief_forms.fields.update');
    Route::post('brief-forms/{id}/fields/{fieldId}/remove', [BriefFormController::class, 'removeField'])
        ->middleware('permission:manage_brief_forms')->name('admin.brief_forms.fields.remove');
    Route::get('brief-submissions', [BriefFormController::class, 'submissions'])
        ->middleware('permission:view_brief_submissions')->name('admin.brief_forms.submissions');
    Route::get('brief-submissions/{id}', [BriefPortalController::class, 'showSubmission'])
        ->middleware('permission:view_brief_submissions')->name('admin.brief_forms.submission');
    Route::get('brief-submissions/{id}/pdf', [BriefFormController::class, 'downloadPdf'])
        ->middleware('permission:view_brief_submissions')->name('admin.brief_forms.pdf');
    Route::get('brief-submissions/{id}/files/{fieldId}', [BriefPortalController::class, 'downloadAttachment'])
        ->middleware('permission:view_brief_submissions')->name('admin.brief_forms.attachment');

    // ------------------------- Transactions -------------------------
    Route::get('transactions', [TransactionController::class, 'index'])
        ->middleware('permission:view_transaction')->name('admin.transactions.index');

    Route::get('payment-recurring', [TransactionController::class, 'payment_recuring'])
        ->middleware('permission:view_recurring')->name('admin.payments-recuring.index');

    Route::post('payment_recharge', [TransactionController::class, 'payment_recharge'])
        ->middleware('permission:view_transaction')->name('payment_recharge');

    Route::post('customer_transactions', [TransactionController::class, 'customer_transactions'])
        ->middleware('permission:view_transaction')->name('customer.transactions');

    Route::post('customer_card_details', [TransactionController::class, 'customer_card_details'])
        ->middleware('permission:view_transaction')->name('customer.card.details');

    Route::get('merchant_configs', [TransactionController::class, 'merchant_configs'])
        ->middleware('permission:merchant_view')->name('merchant.configs');

    // ------------------------- Users / Admins -------------------------
    Route::get('users', [UserController::class, 'index'])
        ->middleware('permission:create_user')->name('users');

    Route::get('users/show/{id}', [UserController::class, 'show'])
        ->middleware('permission:create_user')->name('users.show');

    Route::get('users/create', [UserController::class, 'create'])
        ->middleware('permission:create_user')->name('users.create');

    Route::post('users/store', [UserController::class, 'store'])
        ->middleware('permission:create_user')->name('users.store');

    Route::get('users/edit/{id}', [UserController::class, 'edit'])
        ->middleware('permission:create_user')->name('users.edit');

    Route::post('users/update/{id}', [UserController::class, 'update'])
        ->middleware('permission:create_user')->name('users.update');

    Route::get('users/destroy/{id}', [UserController::class, 'destroy'])
        ->middleware('permission:create_user')->name('users.destroy');

    Route::get('admins', [UserController::class, 'admins_list'])
        ->middleware('permission:create_user')->name('admins.list');
    Route::get('admins/destroy/{id}', [UserController::class, 'admin_destroy'])
        ->middleware('permission:create_user')->name('admins.destroy');
    Route::post('/admins/updateAjax', [UserController::class, 'updateAjax'])
        ->middleware('permission:create_user')->name('admins.updateAjax');
    Route::post('/admins/statusToggle', [UserController::class, 'statusToggle'])
        ->middleware('permission:create_user')->name('admins.statusToggle');

    // ------------------------- Roles & Permissions -------------------------
    Route::get('roles', [RoleController::class, 'index'])
        ->middleware('permission:assign_role_permission')->name('roles.index');
    Route::get('roles/create', [RoleController::class, 'create'])
        ->middleware('permission:assign_role_permission')->name('roles.create');
    Route::post('roles/store', [RoleController::class, 'store'])
        ->middleware('permission:assign_role_permission')->name('roles.store');
    Route::get('roles/edit/{id}', [RoleController::class, 'edit'])
        ->middleware('permission:assign_role_permission')->name('roles.edit');
    Route::post('roles/update/{id}', [RoleController::class, 'update'])
        ->middleware('permission:assign_role_permission')->name('roles.update');
    Route::get('roles/destroy/{id}', [RoleController::class, 'destroy'])
        ->middleware('permission:assign_role_permission')->name('roles.destroy');

    // Route::get('setings', [SettingController::class, 'setings'])->name('settings');

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});
