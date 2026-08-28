@extends('layouts.admin')

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">User Accounts Permission</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.user-accounts.index') }}">User Accounts</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Update User Account Permissions
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <form method="POST" action="{{ route('admin.user-accounts.update', [$user->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <h5 class="card-header">User Account Information</h5>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">E-mail Address</label>
                                    <input type="text" class="form-control" value="{{ $user->email }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <h5 class="card-header">User Permission</h5>
                        <div class="card-body">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingDashboard">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseDashboard" aria-expanded="true"
                                            aria-controls="collapseDashboard">
                                            Dashboard
                                        </button>
                                    </h2>
                                    <div id="collapseDashboard" class="accordion-collapse collapse show"
                                        aria-labelledby="headingDashboard" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="form-check">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="1" id="view-dashboard"
                                                    {{ $user->hasPermissionTo(1) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="view-dashboard">View</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingHomeCarousel">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseHomeCarousel" aria-expanded="false"
                                            aria-controls="collapseHomeCarousel">
                                            Home Carousel Banners
                                        </button>
                                    </h2>
                                    <div id="collapseHomeCarousel" class="accordion-collapse collapse"
                                        aria-labelledby="headingHomeCarousel" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="2" id="view-carousel"
                                                    {{ $user->hasPermissionTo(2) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="view-carousel">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="3" id="delete-carousel"
                                                    {{ $user->hasPermissionTo(3) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="delete-carousel">Delete</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="4" id="edit-carousel"
                                                    {{ $user->hasPermissionTo(4) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="edit-carousel">Update</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="5" id="add-carousel"
                                                    {{ $user->hasPermissionTo(5) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="add-carousel">Create</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingRegSuppliers">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseRegSuppliers"
                                            aria-expanded="false" aria-controls="collapseRegSuppliers">
                                            Registration Suppliers/Exhibitors
                                        </button>
                                    </h2>
                                    <div id="collapseRegSuppliers" class="accordion-collapse collapse"
                                        aria-labelledby="headingRegSuppliers" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="6" id="view-suppliers"
                                                    {{ $user->hasPermissionTo(6) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="view-suppliers">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="70" id="edit-suppliers"
                                                    {{ $user->hasPermissionTo(70) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="edit-suppliers">Update</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="71" id="add-suppliers"
                                                    {{ $user->hasPermissionTo(71) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="add-suppliers">Create</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="7" id="resend-suppliers"
                                                    {{ $user->hasPermissionTo(7) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="resend-suppliers">Resend</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="8" id="review-suppliers"
                                                    {{ $user->hasPermissionTo(8) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="review-suppliers">Review</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="9" id="approve-suppliers"
                                                    {{ $user->hasPermissionTo(9) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="approve-suppliers">Approve</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="10" id="onhold-suppliers"
                                                    {{ $user->hasPermissionTo(10) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="onhold-suppliers">On Hold</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="11" id="disapprove-suppliers"
                                                    {{ $user->hasPermissionTo(11) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="disapprove-suppliers">Disapprove</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="75" id="pending-suppliers"
                                                    {{ $user->hasPermissionTo(75) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pending-suppliers">Pending</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="76" id="pending-suppliers"
                                                    {{ $user->hasPermissionTo(76) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pending-suppliers">Revert</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="79" id="conforme-suppliers"
                                                    {{ $user->hasPermissionTo(79) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="conforme-suppliers">Conforme</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="101" id="resend-conforme-suppliers"
                                                    {{ $user->hasPermissionTo(101) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="resend-conforme-suppliers">Resend Conforme</label>
                                            </div>
                                                <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="80" id="soa-suppliers"
                                                    {{ $user->hasPermissionTo(80) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="soa-suppliers">SOA</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingRegPurchasers">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseRegPurchasers"
                                            aria-expanded="false" aria-controls="collapseRegPurchasers">
                                            Registration Purchaser/Buyer
                                        </button>
                                    </h2>
                                    <div id="collapseRegPurchasers" class="accordion-collapse collapse"
                                        aria-labelledby="headingRegPurchasers" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="12" id="view-buyers"
                                                    {{ $user->hasPermissionTo(12) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="view-buyers">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="72" id="add-buyers"
                                                    {{ $user->hasPermissionTo(72) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="add-buyers">Create</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="73" id="edit-buyers"
                                                    {{ $user->hasPermissionTo(73) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="edit-buyers">Update</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="13" id="resend-buyers"
                                                    {{ $user->hasPermissionTo(13) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="resend-buyers">Resend</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="14" id="review-buyers"
                                                    {{ $user->hasPermissionTo(14) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="review-buyers">Review</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="15" id="approve-buyers"
                                                    {{ $user->hasPermissionTo(15) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="approve-buyers">Approve</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="16" id="onhold-buyers"
                                                    {{ $user->hasPermissionTo(16) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="onhold-buyers">On Hold</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="17" id="disapprove-buyers"
                                                    {{ $user->hasPermissionTo(17) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="disapprove-buyers">Disapprove</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="77" id="pending-buyers"
                                                    {{ $user->hasPermissionTo(77) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pending-buyers">Pending</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="78" id="revert-buyers"
                                                    {{ $user->hasPermissionTo(78) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="revert-buyers">Revert</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingDelegates">
                                        <button
                                            class="accordion-button collapsed"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapseDelegates"
                                            aria-expanded="false"
                                            aria-controls="collapseDelegates"
                                        >
                                            Registration Delegates
                                        </button>
                                    </h2>

                                    <div
                                        id="collapseDelegates"
                                        class="accordion-collapse collapse"
                                        aria-labelledby="headingDelegates"
                                        data-bs-parent="#accordionExample"
                                    >
                                        <div class="accordion-body">

                                            {{-- Delegate Permissions --}}
                                            <div class="mb-3">
                                                <h6 class="fw-bold text-muted mb-2">
                                                    Delegate Management
                                                </h6>

                                                <div class="form-check form-check-inline">
                                                    <input
                                                        class="form-check-input"
                                                        name="permission[]"
                                                        type="checkbox"
                                                        value="85"
                                                        id="view-delegates"
                                                        {{ $user->hasPermissionTo(85) ? 'checked' : '' }}
                                                    >
                                                    <label class="form-check-label" for="view-delegates">
                                                        View
                                                    </label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input
                                                        class="form-check-input"
                                                        name="permission[]"
                                                        type="checkbox"
                                                        value="86"
                                                        id="edit-delegates"
                                                        {{ $user->hasPermissionTo(86) ? 'checked' : '' }}
                                                    >
                                                    <label class="form-check-label" for="edit-delegates">
                                                        Edit
                                                    </label>
                                                </div>

                                                 <div class="form-check form-check-inline">
                                                    <input
                                                        class="form-check-input"
                                                        name="permission[]"
                                                        type="checkbox"
                                                        value="100"
                                                        id="review-delegates"
                                                        {{ $user->hasPermissionTo(100) ? 'checked' : '' }}
                                                    >
                                                    <label class="form-check-label" for="review-delegates">
                                                        Review
                                                    </label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input
                                                        class="form-check-input"
                                                        name="permission[]"
                                                        type="checkbox"
                                                        value="87"
                                                        id="add-delegates"
                                                        {{ $user->hasPermissionTo(87) ? 'checked' : '' }}
                                                    >
                                                    <label class="form-check-label" for="add-delegates">
                                                        Add
                                                    </label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input
                                                        class="form-check-input"
                                                        name="permission[]"
                                                        type="checkbox"
                                                        value="88"
                                                        id="delete-delegates"
                                                        {{ $user->hasPermissionTo(88) ? 'checked' : '' }}
                                                    >
                                                    <label class="form-check-label" for="delete-delegates">
                                                        Delete
                                                    </label>
                                                </div>
                                            </div>

                                            <hr>

                                            {{-- Fee / Discount Permissions --}}
                                            <div class="mb-3">
                                                <h6 class="fw-bold text-muted mb-2">
                                                    Fees & Discounts
                                                </h6>

                                                <div class="form-check form-check-inline">
                                                    <input
                                                        class="form-check-input"
                                                        name="permission[]"
                                                        type="checkbox"
                                                        value="89"
                                                        id="add-fee-delegates"
                                                        {{ $user->hasPermissionTo(89) ? 'checked' : '' }}
                                                    >
                                                    <label class="form-check-label" for="add-fee-delegates">
                                                        Add Fee
                                                    </label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input
                                                        class="form-check-input"
                                                        name="permission[]"
                                                        type="checkbox"
                                                        value="90"
                                                        id="add-discount-delegates"
                                                        {{ $user->hasPermissionTo(90) ? 'checked' : '' }}
                                                    >
                                                    <label class="form-check-label" for="add-discount-delegates">
                                                        Add Discount
                                                    </label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input
                                                        class="form-check-input"
                                                        name="permission[]"
                                                        type="checkbox"
                                                        value="91"
                                                        id="delete-fee-delegates"
                                                        {{ $user->hasPermissionTo(91) ? 'checked' : '' }}
                                                    >
                                                    <label class="form-check-label" for="delete-fee-delegates">
                                                        Delete Fee
                                                    </label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input
                                                        class="form-check-input"
                                                        name="permission[]"
                                                        type="checkbox"
                                                        value="92"
                                                        id="delete-discount-delegates"
                                                        {{ $user->hasPermissionTo(92) ? 'checked' : '' }}
                                                    >
                                                    <label class="form-check-label" for="delete-discount-delegates">
                                                        Delete Discount
                                                    </label>
                                                </div>
                                            </div>

                                            <hr>

                                            {{-- Email Permissions --}}
                                            <div class="mb-3">
                                                <h6 class="fw-bold text-muted mb-2">
                                                    Email
                                                </h6>

                                                <div class="form-check form-check-inline">
                                                    <input
                                                        class="form-check-input"
                                                        name="permission[]"
                                                        type="checkbox"
                                                        value="93"
                                                        id="email-delegates"
                                                        {{ $user->hasPermissionTo(93) ? 'checked' : '' }}
                                                    >
                                                    <label class="form-check-label" for="email-delegates">
                                                        Email Delegates
                                                    </label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input
                                                        class="form-check-input"
                                                        name="permission[]"
                                                        type="checkbox"
                                                        value="94"
                                                        id="email-visitor-buyers"
                                                        {{ $user->hasPermissionTo(94) ? 'checked' : '' }}
                                                    >
                                                    <label class="form-check-label" for="email-visitor-buyers">
                                                        Email Visitor Buyers
                                                    </label>
                                                </div>
                                            </div>

                                            <hr>

                                            {{-- SOA / Billing Permissions --}}
                                            <div>
                                                <h6 class="fw-bold text-muted mb-2">
                                                    SOA / Billing
                                                </h6>

                                                <div class="form-check form-check-inline">
                                                    <input
                                                        class="form-check-input"
                                                        name="permission[]"
                                                        type="checkbox"
                                                        value="95"
                                                        id="generate-soa-delegates"
                                                        {{ $user->hasPermissionTo(95) ? 'checked' : '' }}
                                                    >
                                                    <label class="form-check-label" for="generate-soa-delegates">
                                                        Generate SOA
                                                    </label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input
                                                        class="form-check-input"
                                                        name="permission[]"
                                                        type="checkbox"
                                                        value="96"
                                                        id="approval-soa-delegates"
                                                        {{ $user->hasPermissionTo(96) ? 'checked' : '' }}
                                                    >
                                                    <label class="form-check-label" for="approval-soa-delegates">
                                                        Submit for Approval
                                                    </label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input
                                                        class="form-check-input"
                                                        name="permission[]"
                                                        type="checkbox"
                                                        value="97"
                                                        id="revert-soa-delegates"
                                                        {{ $user->hasPermissionTo(97) ? 'checked' : '' }}
                                                    >
                                                    <label class="form-check-label" for="revert-soa-delegates">
                                                        Return to Generated
                                                    </label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input
                                                        class="form-check-input"
                                                        name="permission[]"
                                                        type="checkbox"
                                                        value="98"
                                                        id="approved-soa-delegates"
                                                        {{ $user->hasPermissionTo(98) ? 'checked' : '' }}
                                                    >
                                                    <label class="form-check-label" for="approved-soa-delegates">
                                                        Approve SOA
                                                    </label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input
                                                        class="form-check-input"
                                                        name="permission[]"
                                                        type="checkbox"
                                                        value="99"
                                                        id="view-soa-delegates"
                                                        {{ $user->hasPermissionTo(99) ? 'checked' : '' }}
                                                    >
                                                    <label class="form-check-label" for="view-soa-delegates">
                                                        View SOA
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingPayments">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapsePayments"
                                            aria-expanded="false" aria-controls="collapsePayments">
                                            Payments
                                        </button>
                                    </h2>
                                    <div id="collapsePayments" class="accordion-collapse collapse"
                                        aria-labelledby="headingPayments" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="81" id="view-payments"
                                                    {{ $user->hasPermissionTo(81) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="view-payments">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="82" id="upload-payments"
                                                    {{ $user->hasPermissionTo(82) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="upload-payments">Upload</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="83" id="update-payments"
                                                    {{ $user->hasPermissionTo(83) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="update-payments">Update</label>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingNewsArticles">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseNewsArticles"
                                            aria-expanded="false" aria-controls="collapseNewsArticles">
                                            News & Articles
                                        </button>
                                    </h2>
                                    <div id="collapseNewsArticles" class="accordion-collapse collapse"
                                        aria-labelledby="headingNewsArticles" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="18" id="view-articles"
                                                    {{ $user->hasPermissionTo(18) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="view-articles">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="19" id="delete-articles"
                                                    {{ $user->hasPermissionTo(19) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="delete-articles">Delete</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="20" id="edit-articles"
                                                    {{ $user->hasPermissionTo(20) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="edit-articles">Update</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="21" id="add-articles"
                                                    {{ $user->hasPermissionTo(21) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="add-articles">Create</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingSolutionsIntelligence">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseSolutionsIntelligence"
                                            aria-expanded="false" aria-controls="collapseSolutionsIntelligence">
                                            Solutions Intelligence
                                        </button>
                                    </h2>
                                    <div id="collapseSolutionsIntelligence" class="accordion-collapse collapse"
                                        aria-labelledby="headingSolutionsIntelligence" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="26" id="view-intelligence"
                                                    {{ $user->hasPermissionTo(26) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="view-intelligence">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="27" id="delete-intelligence"
                                                    {{ $user->hasPermissionTo(27) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="delete-intelligence">Delete</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="28" id="edit-intelligence"
                                                    {{ $user->hasPermissionTo(28) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="edit-intelligence">Update</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="29" id="add-intelligence"
                                                    {{ $user->hasPermissionTo(29) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="add-intelligence">Create</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOnDemandResources">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseOnDemandResources"
                                            aria-expanded="false" aria-controls="collapseOnDemandResources">
                                            On Demand Resources
                                        </button>
                                    </h2>
                                    <div id="collapseOnDemandResources" class="accordion-collapse collapse"
                                        aria-labelledby="headingOnDemandResources" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="30" id="view-ondemand"
                                                    {{ $user->hasPermissionTo(30) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="view-ondemand">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="31" id="delete-ondemand"
                                                    {{ $user->hasPermissionTo(31) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="delete-ondemand">Delete</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="32" id="edit-ondemand"
                                                    {{ $user->hasPermissionTo(32) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="edit-ondemand">Update</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="33" id="add-ondemand"
                                                    {{ $user->hasPermissionTo(33) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="add-ondemand">Create</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingExportEnablers">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseExportEnablers"
                                            aria-expanded="false" aria-controls="collapseExportEnablers">
                                            Export Enablers
                                        </button>
                                    </h2>
                                    <div id="collapseExportEnablers" class="accordion-collapse collapse"
                                        aria-labelledby="headingExportEnablers" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="34" id="view-enablers"
                                                    {{ $user->hasPermissionTo(34) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="view-enablers">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="35" id="delete-enablers"
                                                    {{ $user->hasPermissionTo(35) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="delete-enablers">Delete</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="36" id="edit-enablers"
                                                    {{ $user->hasPermissionTo(36) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="edit-enablers">Update</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="37" id="add-enablers"
                                                    {{ $user->hasPermissionTo(37) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="add-enablers">Create</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOffers">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseOffers"
                                            aria-expanded="false" aria-controls="collapseOffers">
                                            Featured Offers & Programs
                                        </button>
                                    </h2>
                                    <div id="collapseOffers" class="accordion-collapse collapse"
                                        aria-labelledby="headingOffers" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="38" id="view-offers"
                                                    {{ $user->hasPermissionTo(38) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="view-offers">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="39" id="delete-offers"
                                                    {{ $user->hasPermissionTo(39) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="delete-offers">Delete</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="40" id="edit-offers"
                                                    {{ $user->hasPermissionTo(40) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="edit-offers">Update</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="41" id="add-offers"
                                                    {{ $user->hasPermissionTo(41) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="add-offers">Create</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingCertifications">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseCertifications"
                                            aria-expanded="false" aria-controls="collapseCertifications">
                                            Certifications
                                        </button>
                                    </h2>
                                    <div id="collapseCertifications" class="accordion-collapse collapse"
                                        aria-labelledby="headingCertifications" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="42" id="view-certifications"
                                                    {{ $user->hasPermissionTo(42) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="view-certifications">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="43" id="delete-certifications"
                                                    {{ $user->hasPermissionTo(43) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="delete-certifications">Delete</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="44" id="edit-certifications"
                                                    {{ $user->hasPermissionTo(44) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="edit-certifications">Update</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="45" id="add-certifications"
                                                    {{ $user->hasPermissionTo(45) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="add-certifications">Create</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingPages">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapsePages"
                                            aria-expanded="false" aria-controls="collapsePages">
                                            Pages
                                        </button>
                                    </h2>
                                    <div id="collapsePages" class="accordion-collapse collapse"
                                        aria-labelledby="headingPages" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="58" id="view-pages"
                                                    {{ $user->hasPermissionTo(58) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="view-pages">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="59" id="delete-pages"
                                                    {{ $user->hasPermissionTo(59) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="delete-pages">Delete</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="60" id="edit-pages"
                                                    {{ $user->hasPermissionTo(60) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="edit-pages">Update</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="61" id="add-pages"
                                                    {{ $user->hasPermissionTo(61) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="add-pages">Create</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingWidgets">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseWidgets"
                                            aria-expanded="false" aria-controls="collapseWidgets">
                                            Widgets
                                        </button>
                                    </h2>
                                    <div id="collapseWidgets" class="accordion-collapse collapse"
                                        aria-labelledby="headingWidgets" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="46" id="view-widgets"
                                                    {{ $user->hasPermissionTo(46) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="view-widgets">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="47" id="delete-widgets"
                                                    {{ $user->hasPermissionTo(47) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="delete-widgets">Delete</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="48" id="edit-widgets"
                                                    {{ $user->hasPermissionTo(48) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="edit-widgets">Update</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="49" id="add-widgets"
                                                    {{ $user->hasPermissionTo(49) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="add-widgets">Create</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingSEO">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseSEO" aria-expanded="false"
                                            aria-controls="collapseSEO">
                                            SEO Pages Meta Tags
                                        </button>
                                    </h2>
                                    <div id="collapseSEO" class="accordion-collapse collapse"
                                        aria-labelledby="headingSEO" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="50" id="view-seo"
                                                    {{ $user->hasPermissionTo(50) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="view-seo">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="51" id="delete-seo"
                                                    {{ $user->hasPermissionTo(51) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="delete-seo">Delete</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="52" id="edit-seo"
                                                    {{ $user->hasPermissionTo(52) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="edit-seo">Update</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="53" id="add-seo"
                                                    {{ $user->hasPermissionTo(53) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="add-seo">Create</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingEvents">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseEvents"
                                            aria-expanded="false" aria-controls="collapseEvents">
                                            Events & Activities
                                        </button>
                                    </h2>
                                    <div id="collapseEvents" class="accordion-collapse collapse"
                                        aria-labelledby="headingEvents" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="54" id="view-events"
                                                    {{ $user->hasPermissionTo(54) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="view-events">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="55" id="delete-events"
                                                    {{ $user->hasPermissionTo(55) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="delete-events">Delete</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="56" id="edit-events"
                                                    {{ $user->hasPermissionTo(56) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="edit-events">Update</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="57" id="add-events"
                                                    {{ $user->hasPermissionTo(57) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="add-events">Create</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingExhibitions">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseExhibitions"
                                            aria-expanded="false" aria-controls="collapseExhibitions">
                                            Exhibitions & Conferences
                                        </button>
                                    </h2>
                                    <div id="collapseExhibitions" class="accordion-collapse collapse"
                                        aria-labelledby="headingExhibitions" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="62" id="view-conference"
                                                    {{ $user->hasPermissionTo(62) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="view-conference">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="63" id="delete-conference"
                                                    {{ $user->hasPermissionTo(63) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="delete-conference">Delete</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="64" id="edit-conference"
                                                    {{ $user->hasPermissionTo(64) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="edit-conference">Update</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="65" id="add-conference"
                                                    {{ $user->hasPermissionTo(65) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="add-conference">Create</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingVideos">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseVideos"
                                            aria-expanded="false" aria-controls="collapseVideos">
                                            Conferences Youtube Videos
                                        </button>
                                    </h2>
                                    <div id="collapseVideos" class="accordion-collapse collapse"
                                        aria-labelledby="headingVideos" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="66" id="view-video"
                                                    {{ $user->hasPermissionTo(66) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="view-video">View</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="67" id="delete-video"
                                                    {{ $user->hasPermissionTo(67) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="delete-video">Delete</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="68" id="edit-video"
                                                    {{ $user->hasPermissionTo(68) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="edit-video">Update</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="permission[]" type="checkbox"
                                                    value="69" id="add-video"
                                                    {{ $user->hasPermissionTo(69) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="add-video">Create</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <h5 class="card-header">Actions</h5>
                        <div class="card-body">
                            @if ($user->status === 1)
                                <p class="fs-3 p-3 mb-2 bg-success text-white">Active</p>
                            @else
                                <p class="fs-3 p-3 mb-2 bg-danger text-white">Suspended</p>
                            @endif
                            <div class="form-group row">
                                <div class="form-group">
                                    <label class="form-label">Date Created</label>
                                    <input type="text" class="form-control form-control-sm"
                                        value="{{ $user->created_at->format('F j, Y, g:i A') }}" readonly />
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Date Updated</label>
                                    <input type="text" class="form-control form-control-sm"
                                        value="{{ $user->updated_at->format('F j, Y, g:i A') }}" readonly />
                                </div>
                                <hr class="w-100 mt-2">
                                <div class="d-grid gap-2 mt-3">
                                    <button class="btn btn-success text-white" type="submit">Update Permission</button>
                                    <a href="{{ route('admin.user-accounts.index') }}" class="btn btn-secondary"
                                        role="button">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('styles')
@endpush
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#nav-user-accounts').addClass('selected');
            $('#subnav-user-accounts').addClass('active');

            $("#toggle_pwd1 i").click(function() {
                $(this).toggleClass("fa-eye fa-eye-slash");
                var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
                $("#password").attr("type", type);
            });

            $("#toggle_pwd2 i").click(function() {
                $(this).toggleClass("fa-eye fa-eye-slash");
                var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
                $("#password_confirmation").attr("type", type);
            });
        });
    </script>
@endpush
