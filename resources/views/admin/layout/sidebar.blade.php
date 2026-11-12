<!-- START: Main Menu-->
@php
    $authUser = auth_staff();
@endphp
<div class="sidebar">
    <div class="site-width">
        <!-- START: Menu-->
        <ul id="side-menu" class="sidebar-menu">
            <li class="dropdown"><a href="javascript:void(0);"><i class="icon-home mr-1"></i> Dashboard</a>
                <ul>
                    <li><a href="{{ route('dashboard') }}"><i class="icon-speedometer"></i> Dashboard</a></li>
                </ul>
            </li>
            <li class="dropdown"><a href="javascript:void(0);" id="brand-management"><i class="icon-tag mr-1"></i> Brand
            Management</a>
                <ul>
                    @if ($authUser->has_permission('brand_view'))
                        <li><a href="{{ route('admin.brands.index') }}"><i class="icon-briefcase"></i>All Brands</a></li>
                    @endif
                    @if ($authUser->has_permission('packages_view'))
                        <li><a href="{{ route('packages') }}"><i class="icon-organization"></i>Packages</a></li>
                    @endif
                    @if ($authUser->has_permission('merchant_view'))
                        <li><a href="{{ route('merchant.index') }}"><i class="icon-credit-card"></i>Merchants</a></li>
                    @endif
                        {{-- <li><a href=""><i class="icon-support"></i>Unpaid Inquiry</a></li>
                            <li><a href=""><i class="icon-support"></i>Contact Inquiry</a></li> --}}
                    </ul>
                </li>
           
            <li class="dropdown"><a href="javascript:void(0);"><i class="icon-basket mr-1"></i> Order Management</a>

                <ul>
                    @if ($authUser->has_permission('create_payment_link'))
                        <li><a href="{{ route('payment.create_order') }}"><i class="icon-plus"></i>Create
                                Order</a></li>
                    @endif
                    @if ($authUser->has_permission('view_all_orders') || $authUser->has_permission('view_only_his_order'))
                        <li><a href="{{ route('admin.orders.index') }}"><i class="icon-list"></i>Orders</a>
                        </li>
                    @endif
                    {{--
                    @if ($authUser->has_permission('view_only_his_order'))
                        <li><a href="{{ route('admin.orders.own') }}"><i class="icon-list"></i>My Orders</a>
                        </li>
                    @endif
                    --}}
                    @if ($authUser->has_permission('view_transaction'))
                        <li><a href="{{ route('admin.transactions.index') }}"><i
                                    class="icon-credit-card"></i>Transactions</a></li>
                    @endif
                    @if ($authUser->has_permission('view_recurring'))
                        <li><a href="{{ route('admin.payments-recuring.index') }}"><i class="icon-refresh"></i>Payment
                                Recurring</a></li>
                    @endif
                </ul>

            </li>
            @if ($authUser->has_permission('view_assigned_client') || $authUser->has_permission('view_payment_link') || $authUser->has_permission('manage_brief_forms') || $authUser->has_permission('send_brief_forms') || $authUser->has_permission('view_brief_submissions'))
                <li class="dropdown"><a href="javascript:void(0);"><i class="icon-people mr-1"></i> Support</a>
                    <ul>
                        @if ($authUser->has_permission('view_assigned_client'))
                            <li><a href="{{ route('admin.assigned_clients') }}"><i class="icon-people"></i>Clients</a></li>
                        @endif
                        @if ($authUser->has_permission('view_payment_link'))
                            <li><a href="{{ route('admin.payment_links') }}"><i class="icon-book-open"></i>Invoice (Payment
                                    Link)</a></li>
                        @endif
                        @if ($authUser->has_permission('manage_brief_forms'))
                            <li><a href="{{ route('admin.brief_forms.index') }}"><i class="icon-list"></i>Brief Form Templates</a></li>
                        @endif
                        @if ($authUser->has_permission('view_brief_submissions'))
                            <li><a href="{{ route('admin.brief_forms.submissions') }}"><i class="icon-doc"></i>Brief Submissions</a></li>
                        @endif
                    </ul>
                </li>
            @endif
            @if ($authUser->has_permission('create_user'))
                <li class="dropdown"><a href="javascript:void(0);"><i class="icon-people mr-1"></i> User
                        Management</a>
                    <ul>
                        <li><a href="{{ route('users') }}"><i class="icon-user"></i>Users</a></li>
                        @if ($authUser->isSuperAdmin())
                            <li><a href="{{ route('admins.list') }}"><i class="icon-user"></i>Admins</a></li>
                        @endif
                    </ul>
                </li>
            @endif
            @if ($authUser->has_permission('assign_role_permission'))
                <li class="dropdown"><a href="javascript:void(0);"><i class="icon-lock mr-1"></i> Roles &amp; Permissions</a>
                    <ul>
                        <li><a href="{{ route('roles.index') }}"><i class="icon-key"></i>Roles</a></li>
                    </ul>
                </li>
            @endif
            {{--
                <li class="dropdown"><a href="javascript:void(0);"><i class="icon-organization mr-1"></i> Settings</a>
                    
                    <ul>
                        <li><a href="{{ route('settings') }}"><i class="icon-gears"></i>Packages</a></li>
                    </ul>
                </li>
                --}}
            {{--
                <li class="dropdown"><a href="javascript:void(0);"><i class="icon-layers mr-1"></i> Web Apps</a>                  
                    <ul>
                        <li><a href="app-calendar.html"><i class="icon-calendar"></i> Calendar</a></li>
                        <li><a href="app-chat.html"><i class="icon-speech"></i> Chats</a></li>
                        <li><a href="app-to-do.html"><i class="icon-support"></i> Todo</a></li> 
                        <li><a href="app-mail.html"><i class="icon-envelope"></i>Mailapp</a></li>
                        <li><a href="app-filemanager.html"><i class="icon-folder"></i> File Manager</a></li>
                        <li><a href="app-contactlist.html"><i class="icon-people"></i> Contact List</a></li>
                        <li><a href="app-taskboard.html"><i class="icon-event"></i> Task Board</a></li>
                        <li><a href="app-notes.html"><i class="icon-tag"></i> Notes</a></li> 
                        <li><a href="app-invoicelist.html"><i class="icon-book-open"></i> Invoices</a></li>
                    </ul>                   
                </li>
                --}}
        </ul>
        <!-- END: Menu-->

    </div>
</div>
<!-- END: Main Menu-->
