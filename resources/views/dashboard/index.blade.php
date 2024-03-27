<?php $title = 'Dashboard'; ?>
@extends('layouts.app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
<div class="row">

<!-- View sales -->
<div class="col-xl-4 mb-4 col-lg-5 col-12">
    <div class="card h-100">
    <div class="d-flex align-items-end row">
        <div class="col-7">
        <div class="card-body text-nowrap">
        @if('1' == '2')
        <h5 class="card-title mb-0">Congratulations John! ðŸŽ‰</h5>
        <p class="mb-2">Best seller of the month</p>
        <h4 class="text-primary mb-1">$48.9k</h4>
        @else
        <h5 class="card-title mb-0">Welcome {{ Auth::user()->first_name }},</h5>
        
            @if(Auth::user()->hasRole('SuperAdmin'))
            <p> What would you like to do today?</p>
            <br/>
            <p></p>
            @else
            <p class="mb-2">You currently have <strong> {{ totalEmpRfqs(json_decode(empDet(Auth::user()->email))[0]->employee_id)}} </strong> Active RFQs 
            <br/>
            You have Converted <strong> {{ totalEmpPoMnth(json_decode(empDet(Auth::user()->email))[0]->employee_id)}} </strong> POs This Month</p>
            @endif
        @endif
            <a href="{{ route('rfq.index') }}" class="btn btn-primary">View RFQs</a>
        </div>
        </div>
        <div class="col-5 text-center text-sm-left">
        <div class="card-body pb-0 px-0 px-md-4">
            <img
            src="{{asset('admin/assets/img/illustrations/card-advance-sale.png')}}"
            height="140"
            alt="User"
            />
        </div>
        </div>
    </div>
    </div>
</div>
<!-- View sales -->

<!-- Statistics -->
<div class="col-xl-8 mb-4 col-lg-7 col-12">
    <div class="card h-100">
    <div class="card-header">
        <div class="d-flex justify-content-between mb-3">
        <h5 class="card-title mb-0">Statistics</h5>
        <small class="text-muted">Updated in Real-Time</small>
        </div>
    </div>
    <div class="card-body">
        <div class="row gy-3">
        <div class="col-md-3 col-6">
            <div class="d-flex align-items-center">
            <div class="badge rounded-pill bg-label-primary me-3 p-2">
                <i class="ti ti-pencil ti-sm"></i>
            </div>
            <div class="card-info">
                <h5 class="mb-0">{{ count($rfq) ?? 0}}</h5>
                <small>RFQs</small>
            </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="d-flex align-items-center">
            <div class="badge rounded-pill bg-label-info me-3 p-2">
                <i class="ti ti-clipboard ti-sm"></i>
            </div>
            <div class="card-info">
                <h5 class="mb-0">{{ count($po) ?? 0}}</h5>
                <small>POs</small>
            </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="d-flex align-items-center">
            <div class="badge rounded-pill bg-label-danger me-3 p-2">
                <i class="ti ti-user ti-sm"></i>
            </div>
            <div class="card-info">
                <h5 class="mb-0">{{ count($client) ?? 0}}</h5>
                <small>Clients</small>
            </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="d-flex align-items-center">
            <div class="badge rounded-pill bg-label-success me-3 p-2">
                <i class="ti ti-settings ti-sm"></i>
            </div>
            <div class="card-info">
                <h5 class="mb-0">{{ count($vendor) ?? 0}}</h5>
                <small>Suppliers</small>
            </div>
            </div>
        </div>
        <!-- <div class="col-md-2 col-6">
            <div class="d-flex align-items-center">
            <div class="badge rounded-pill bg-label-success me-3 p-2">
                <i class="ti ti-truck ti-sm"></i>
            </div>
            <div class="card-info">
                <h5 class="mb-0">{{ count($shipper) ?? 0}}</h5>
                <small>Shipper</small>
            </div>
            </div>
        </div> -->
        </div>
    </div>
    </div>
</div>
<!--/ Statistics -->

<div class="col-lg-6 mb-4">
                  <div
                    class="swiper-container swiper-container-horizontal swiper swiper-card-advance-bg"
                    id="swiper-with-pagination-cards"
                  >
                    <div class="swiper-wrapper" >
                      <div class="swiper-slide" style="background-color:#28c76f !important;">
                          <div class="row">
                            <div class="col-lg-7 col-md-9 col-12 order-2 order-md-1">
                            <h5 class="text-white mb-0 mt-2">SCM Analytics</h5>
                            <small>Total {{ Totalrfqs() != 0 ? number_format(((Totalrfqs() - Totalpos()) / Totalrfqs()) * 100, 2) : 0 }}% Conversion Rate</small>
                              <h6 class="text-white mt-0 mt-md-3 mb-3">RFQs</h6>
                              <div class="row">
                                <div class="col-6">
                                  <ul class="list-unstyled mb-0">
                                    <li class="d-flex mb-4 align-items-center">
                                      <p class="mb-0 fw-semibold me-2 website-analytics-text-bg" style="background-color:#1ea55a !important;">{{totalActiveRfqs()}}</p>
                                      <p class="mb-0">Active</p>
                                    </li>
                                    <li class="d-flex align-items-center mb-2">
                                      <p class="mb-0 fw-semibold me-2 website-analytics-text-bg" style="background-color:#1ea55a !important;">{{TotalrfqsAwaitingApproval()}}</p>
                                      <p class="mb-0">Awaiting Approval</p>
                                    </li>
                                  </ul>
                                </div>
                                <div class="col-6">
                                  <ul class="list-unstyled mb-0">
                                    <li class="d-flex mb-4 align-items-center">
                                      <p class="mb-0 fw-semibold me-2 website-analytics-text-bg" style="background-color:#1ea55a !important;">{{TotalrfqsBidClosed()}}</p>
                                      <p class="mb-0">Bid Closed</p>
                                    </li>
                                    <li class="d-flex align-items-center mb-2">
                                      <p class="mb-0 fw-semibold me-2 website-analytics-text-bg" style="background-color:#1ea55a !important;">{{TotalrfqsApproved()}}</p>
                                      <p class="mb-0">Approved</p>
                                    </li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-5 col-md-3 col-12 order-1 order-md-2 my-4 my-md-0 text-center">
                              <img
                                src="{{asset('admin/assets/img/illustrations/card-website-analytics-1.png')}}"
                                alt="Website Analytics"
                                width="170"
                                class="card-website-analytics-img"
                              />
                            </div>
                          </div>
                        </div>
                      <div class="swiper-slide" style="background-color:#28c76f !important;">
                        <div class="row">
                          <div class="col-lg-7 col-md-9 col-12 order-2 order-md-1" >
                          <h5 class="text-white mb-0 mt-2">SCM Analytics</h5>
                            <small>Total {{ Totalrfqs() != 0 ? number_format((Totalpos() / Totalrfqs()) * 100, 2) : 0 }}% Conversion Rate</small>
                            <h6 class="text-white mt-0 mt-md-3 mb-3">Purchase Orders</h6>
                            <div class="row">
                              <div class="col-6">
                                <ul class="list-unstyled mb-0">
                                  <li class="d-flex mb-4 align-items-center">
                                    <p class="mb-0 fw-semibold me-2 website-analytics-text-bg" style="background-color:#1ea55a !important;">{{TotalActivePos()}}</p>
                                    <p class="mb-0">Active</p>
                                  </li>
                                  <li class="d-flex align-items-center mb-2">
                                    <p class="mb-0 fw-semibold me-2 website-analytics-text-bg" style="background-color:#1ea55a !important;">{{TotalposInTransit()}}</p>
                                    <p class="mb-0">In-Transit</p>
                                  </li>
                                </ul>
                              </div>
                              <div class="col-6">
                                <ul class="list-unstyled mb-0">
                                  <li class="d-flex mb-4 align-items-center">
                                    <p class="mb-0 fw-semibold me-2 website-analytics-text-bg" style="background-color:#1ea55a !important;">{{TotalposDelivered()}}</p>
                                    <p class="mb-0">Delivered</p>
                                  </li>
                                  <li class="d-flex align-items-center mb-2">
                                    <p class="mb-0 fw-semibold me-2 website-analytics-text-bg" style="background-color:#1ea55a !important;">{{TotalposGRN()}}</p>
                                    <p class="mb-0">Awaiting GRN</p>
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-5 col-md-3 col-12 order-1 order-md-2 my-4 my-md-0 text-center">
                            <img
                              src="{{asset('admin/assets/img/illustrations/card-website-analytics-2.png')}}"
                              alt="Website Analytics"
                              width="170"
                              class="card-website-analytics-img"
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-pagination"></div>
                  </div>
                </div>

<!-- Sales Overview -->
                <div class="col-lg-3 col-sm-6 mb-4">
                  <div class="card">
                    <div class="card-header">
                      <div class="d-flex justify-content-between">
                        <small class="d-block mb-1 text-muted">Conversion Overview</small>
                        <p class="card-text text-success">{{date('Y')}}</p>
                      </div>
                      <h3 class="card-title mb-1">${{ formatNumber(TotalrfqQuote()) }}
                      @php
                      function formatNumber($value) {
                          if ($value < 1000) {
                              return number_format($value, 1);
                          } elseif ($value < 1000000) {
                              return number_format($value / 1000, 1) . 'k';
                          } else {
                              return number_format($value / 1000000, 1) . 'm';
                          }
                      }
                      @endphp</h3>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-4">
                          <div class="d-flex gap-2 align-items-center mb-2">
                            <span class="badge bg-label-info p-1 rounded"
                              ><i class="ti ti-shopping-cart ti-xs"></i
                            ></span>
                            <p class="mb-0">RFQs</p>
                          </div>
                          <h5 class="mb-0 pt-1 text-nowrap">{{ Totalrfqs() != 0 ? number_format(((Totalrfqs() - Totalpos()) / Totalrfqs()) * 100, 2) : 0}}%</h5>
                          <small class="text-muted">{{ Totalrfqs() }}</small>
                        </div>
                        <div class="col-4">
                          <div class="divider divider-vertical">
                            <div class="divider-text">
                              <span class="badge-divider-bg bg-label-secondary">VS</span>
                            </div>
                          </div>
                        </div>
                        <div class="col-4 text-end">
                          <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                            <p class="mb-0">POs</p>
                            <span class="badge bg-label-primary p-1 rounded"><i class="ti ti-link ti-xs"></i></span>
                          </div>
                          <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">{{ Totalrfqs() != 0 ? number_format((Totalpos() / Totalrfqs()) * 100, 2) : 0 }}%</h5>
                          <small class="text-muted">{{ Totalpos() }}</small>
                        </div>
                      </div>
                      <div class="d-flex align-items-center mt-4">
                        <div class="progress w-100" style="height: 8px">
                          <div
                            class="progress-bar bg-info"
                            style="width: {{ Totalrfqs() != 0 ? number_format(((Totalrfqs() - Totalpos()) / Totalrfqs()) * 100, 2) : 0}}%"
                            role="progressbar"
                            aria-valuenow="{{ Totalrfqs() != 0 ? number_format(((Totalrfqs() - Totalpos()) / Totalrfqs()) * 100, 2) : 0 }}"
                            aria-valuemin="0"
                            aria-valuemax="100"
                          ></div>
                          <div
                            class="progress-bar bg-primary"
                            role="progressbar"
                            style="width: {{ Totalrfqs() != 0 ? number_format((Totalpos() / Totalrfqs()) * 100, 2) : 0 }}%"
                            aria-valuenow="{{ Totalrfqs() != 0 ? number_format((Totalpos() / Totalrfqs()) * 100, 2) : 0 }}"
                            aria-valuemin="0"
                            aria-valuemax="100"
                          ></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
<!--/ Sales Overview -->

<!-- Revenue Generated -->
  <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                  <div class="card">
                    <div class="card-body pb-0">
                      <div class="card-icon">
                        <span class="badge bg-label-success rounded-pill p-2">
                          <i class="ti ti-credit-card ti-sm"></i>
                        </span>
                      </div>
                      <h4 class="card-title mb-0 mt-2">{{ formatValue(TotalpoQuoteForeign())}}
                      @php
                      function formatValue($value) {
                          if ($value < 1000) {
                              return number_format($value, 1);
                          } elseif ($value < 1000000) {
                              return number_format($value / 1000, 1) . 'k';
                          } else {
                              return number_format($value / 1000000, 1) . 'm';
                          }
                      }
                      @endphp
                      </h4>
                      <small>Revenue Generated</small>
                    </div>
                    <div id="revenueGenerated"></div>
                  </div>
                </div>
<!--/ Revenue Generated -->

 <!-- Earning Reports -->
 <div class="col-xl-4 col-lg-5 col-md-6 mb-4">
                  <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                      <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Earning Reports</h5>
                        <small class="text-muted">Annual Earnings Overview</small>
                      </div>
                    </div>
                    <div class="card-body pb-0">
                      <ul class="p-0 m-0">
                        <li class="d-flex mb-3">
                          <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-primary"
                              ><i class="ti ti-chart-pie-2 ti-sm"></i
                            ></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Net Profit</h6>
                              <small class="text-muted">37 POs</small>
                            </div>
                            <div class="user-progress">
                              <small>$143,619</small><i class="ti ti-chevron-up text-success ms-3"></i>
                              <small class="text-muted">18.6%</small>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex mb-3">
                          <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-success"
                              ><i class="ti ti-currency-dollar ti-sm"></i
                            ></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Total Expenses</h6>
                              <small class="text-muted">Supplier Costs</small>
                            </div>
                            <div class="user-progress">
                              <small>$391,571</small><i class="ti ti-chevron-up text-success ms-3"></i>
                              <small class="text-muted">39.6%</small>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex mb-3">
                          <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-secondary"
                              ><i class="ti ti-credit-card ti-sm"></i
                            ></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Top Performer</h6>
                              <small class="text-muted">Admin Admin</small>
                            </div>
                            <div class="user-progress">
                              <small>4</small><i class="ti ti-chevron-up text-success ms-3"></i>
                              <small class="text-muted">POs</small>
                            </div>
                          </div>
                        </li>
                      </ul>
                      <div id="reportBarChart"></div>
                    </div>
                  </div>
                </div>
<!--/ Earning Reports -->

<!-- Popular Product -->
                <div class="col-md-6 col-xl-4 mb-4">
                  <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                      <div class="card-title m-0 me-2">
                        <h5 class="m-0 me-2">Frequently Requested Products</h5>
                        <small class="text-muted">Most Requested Products</small>
                      </div>
                      <div class="dropdown">
                        <button
                          class="btn p-0"
                          type="button"
                          id="popularProduct"
                          data-bs-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false"
                        >
                          <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="popularProduct">
                          <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                          <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                          <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                      <ul class="p-0 m-0">
                      @php
                            $specifiedWords = ['Valve', 'Gasket', 'Bolt and Nut', 'Flange', 'Pipes', 'Acoustic Slab', 'Rotork'];
                            $wordCounts = getWordCounts($specifiedWords);
                        @endphp

                        @foreach ($wordCounts as $word => $totalCount)                        
                        <li class="d-flex mb-4 pb-1">
                          <div class="me-3">
                          <i class="ti ti-settings ti-sm"></i>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">{{ $word }}</h6>
                              <small class="text-muted d-block">Item</small>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                              <p class="mb-0 fw-semibold">{{ $totalCount }}</p>
                            </div>
                          </div>
                        </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                </div>
<!--/ Popular Product -->

<!-- Sales by Countries tabs-->
                <div class="col-md-6 col-xl-4 col-xl-4 mb-4">
                  <div class="card h-100">
                    <div class="card-header d-flex justify-content-between pb-2 mb-1">
                      <div class="card-title mb-1">
                        <h5 class="m-0 me-2">RFQs by Clients</h5>
                        <small class="text-muted">Quick Details on RFQs</small>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="nav-align-top">
                        <ul class="nav nav-tabs nav-fill" style="width:100% !important; margin-left:1% !important; " role="tablist">
                          <li class="nav-item">
                            <button
                              type="button"
                              class="nav-link active"
                              role="tab"
                              data-bs-toggle="tab"
                              data-bs-target="#navs-justified-new"
                              aria-controls="navs-justified-new"
                              aria-selected="true"
                            >
                              New
                            </button>
                          </li>
                          <li class="nav-item">
                            <button
                              type="button"
                              class="nav-link"
                              role="tab"
                              data-bs-toggle="tab"
                              data-bs-target="#navs-justified-link-preparing"
                              aria-controls="navs-justified-link-preparing"
                              aria-selected="false"
                            >
                              Awaiting Approval
                            </button>
                          </li>
                          <li class="nav-item">
                            <button
                              type="button"
                              class="nav-link"
                              role="tab"
                              data-bs-toggle="tab"
                              data-bs-target="#navs-justified-link-shipping"
                              aria-controls="navs-justified-link-shipping"
                              aria-selected="false"
                            >
                              PO Issued
                            </button>
                          </li>
                        </ul>
                        <div class="tab-content pb-0">
                          <div class="tab-pane fade show active" id="navs-justified-new" role="tabpanel">
                            @php
                             $newrfqs = getNewRfqs();
                             $awaitings = getAwaitingRfqs();
                             $issueds = getPOIssuedRfqs();
                            @endphp
                            @foreach($newrfqs as $index => $newrfq)
                            <ul class="timeline timeline-advance timeline-advance mb-2 pb-1">
                              <li class="timeline-item ps-4 border-left-dashed">
                                <span class="timeline-indicator timeline-indicator-success">
                                  <i class="ti ti-circle-check"></i>
                                </span>
                                <div class="timeline-event ps-0 pb-0">
                                  <div class="timeline-header">
                                    <small class="text-success text-uppercase fw-semibold">{{$newrfq->refrence_no}} | {{$newrfq->rfq_date}}</small>
                                  </div>
                                  <h6 class="mb-0">{{clits($newrfq->client_id)->client_name}}</h6>
                                  <p class="text-muted mb-0 text-nowrap">{{ fbuyers($newrfq->contact_id)->first_name ?? '' }} {{fbuyers($newrfq->contact_id)->last_name ?? '' }}</p>
                                </div>
                              </li>
                              <li class="timeline-item ps-4 border-0">
                                <span class="timeline-indicator timeline-indicator-primary">
                                  <i class="ti ti-map-pin"></i>
                                </span>
                                <div class="timeline-event ps-0 pb-0">
                                  <div class="timeline-header">
                                    <small class="text-primary text-uppercase fw-semibold">Supplier</small>
                                  </div>
                                  <h6 class="mb-0">{{SupplierDetails($newrfq->vendor_id)->vendor_name}}</h6>
                                  <p class="text-muted mb-0 text-nowrap">{{ Illuminate\Support\Str::limit($newrfq->product, 30, '...') }}</p>
                                </div>
                              </li>
                            </ul>
                            @if($index === 0)
                                <div class="border-bottom border-bottom-dashed mt-0 mb-4"></div>
                            @endif
                            @endforeach
                          </div>

                          <div class="tab-pane fade" id="navs-justified-link-preparing" role="tabpanel">
                          @foreach($awaitings as $index => $awaiting)
                            <ul class="timeline timeline-advance timeline-advance mb-2 pb-1">
                              <li class="timeline-item ps-4 border-left-dashed">
                                <span class="timeline-indicator timeline-indicator-success">
                                  <i class="ti ti-circle-check"></i>
                                </span>
                                <div class="timeline-event ps-0 pb-0">
                                  <div class="timeline-header">
                                    <small class="text-success text-uppercase fw-semibold">{{$awaiting->refrence_no}} | {{$awaiting->rfq_date}}</small>
                                  </div>
                                  <h6 class="mb-0">{{clits($awaiting->client_id)->client_name}}</h6>
                                  <p class="text-muted mb-0 text-nowrap">{{ fbuyers($awaiting->contact_id)->first_name ?? '' }} {{fbuyers($awaiting->contact_id)->last_name ?? '' }}</p>
                                </div>
                              </li>
                              <li class="timeline-item ps-4 border-0">
                                <span class="timeline-indicator timeline-indicator-primary">
                                  <i class="ti ti-map-pin"></i>
                                </span>
                                <div class="timeline-event ps-0 pb-0">
                                  <div class="timeline-header">
                                    <small class="text-primary text-uppercase fw-semibold">Supplier</small>
                                  </div>
                                  <h6 class="mb-0">{{SupplierDetails($awaiting->vendor_id)->vendor_name}}</h6>
                                  <p class="text-muted mb-0 text-nowrap">{{ Illuminate\Support\Str::limit($awaiting->product, 30, '...') }}</p>
                                </div>
                              </li>
                            </ul>
                            @if($index === 0)
                                <div class="border-bottom border-bottom-dashed mt-0 mb-4"></div>
                            @endif
                            @endforeach
                          </div>
                          <div class="tab-pane fade" id="navs-justified-link-shipping" role="tabpanel">
                          @foreach($issueds as $index => $issued)
                            <ul class="timeline timeline-advance timeline-advance mb-2 pb-1">
                              <li class="timeline-item ps-4 border-left-dashed">
                                <span class="timeline-indicator timeline-indicator-success">
                                  <i class="ti ti-circle-check"></i>
                                </span>
                                <div class="timeline-event ps-0 pb-0">
                                  <div class="timeline-header">
                                    <small class="text-success text-uppercase fw-semibold">{{$issued->refrence_no}} | {{$issued->rfq_date}}</small>
                                  </div>
                                  <h6 class="mb-0">{{clits($issued->client_id)->client_name}}</h6>
                                  <p class="text-muted mb-0 text-nowrap">{{ fbuyers($issued->contact_id)->first_name ?? '' }} {{fbuyers($issued->contact_id)->last_name ?? '' }}</p>
                                </div>
                              </li>
                              <li class="timeline-item ps-4 border-0">
                                <span class="timeline-indicator timeline-indicator-primary">
                                  <i class="ti ti-map-pin"></i>
                                </span>
                                <div class="timeline-event ps-0 pb-0">
                                  <div class="timeline-header">
                                    <small class="text-primary text-uppercase fw-semibold">Supplier</small>
                                  </div>
                                  <h6 class="mb-0">{{SupplierDetails($issued->vendor_id)->vendor_name}}</h6>
                                  <p class="text-muted mb-0 text-nowrap">{{ Illuminate\Support\Str::limit($issued->product, 30, '...') }}</p>
                                </div>
                              </li>
                            </ul>
                            @if($index === 0)
                                <div class="border-bottom border-bottom-dashed mt-0 mb-4"></div>
                            @endif
                            @endforeach
                          </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
<!--/ Sales by Countries tabs -->

</div>
    <!-- Page header start -->
    <!-- <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">SCM Dashboard</li>
        </ol>
        @include('layouts.logo')
    </div> -->

    <div class="content-wrapperx">
        @include('layouts.alert')
        <!-- Row start -->
        <div class="row gutters">
            @if(( Auth::user()->email_verified_at) == "")

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="card">
                        <div class="card-body">
                            <h6><p style="color:red" align="center">You Have Not Verify Your Account Please Kindly Visit
                                <b>{{Auth::user()->email}}</b> for the verification link </p>
                            </h6>
                        </div>
                    </div>

                </div>
            @else
                @if (Gate::allows('SuperAdmin', auth()->user()))
<!-- 
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('company.index') }}'">
                        <div class="icon-tiles red" style="background:#17a2b8">
                            <h2 align="left">{{ count($company) ?? 0 }}</h2>
                            <b><p style="margin-top:-20px"> Companies</p></b>
                            <img src="{{asset('admin/img/icons/organization.svg')}}" style="height:250px; width:250px" alt="Companies" />
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('vendor.index') }}'">
                        <div class="icon-tiles cyan" style="background:#d5ad2a">
                            <h2 align="left">{{ count($vendor) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> Suppliers</p></b>
                            <img src="{{asset('admin/img/icons/supplier2.svg')}}" style="height:300px; width:450px" alt="Suppliers" />
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('client.index') }}'">
                        <div class="icon-tiles indigo" style="background:#20c997">
                            <h2 align="left">{{ count($client) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> Clients</p></b>
                            <img src="{{asset('admin/img/icons/crm.svg')}}" alt="Clients" style="color:white" />

                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('rfq.index') }}'">
                        <div class="icon-tiles primary" style="background: purple">
                            <h2 align="left">{{ count($rfq) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> RFQs</p></b>
                            <img src="{{asset('admin/img/icons/appointment.svg')}}" alt="Client RFQs" />

                        </div>
                    </div>
                    
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('shipper.index') }}'">

                        <div class="icon-tiles teal" style="background:#6610f2">
                            <h2 align="left">{{ count($shipper) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> Shippers</p></b>
                            <img src="{{asset('admin/img/icons/staff.svg')}}" alt="Shippers" />

                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12"  onclick="location.href='{{ route('po.index') }}'" >
                        <div class="icon-tiles blue" style="background:#007bff">
                            <h2 align="left">{{ count($po) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> PO</p></b>
                            <img src="{{asset('admin/img/icons/patient.svg')}}" alt="Client POs" />

                        </div>
                    </div> -->
                @elseif(Auth::user()->hasRole('Admin'))
                    <!-- <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('client.index') }}'">
                        <div class="icon-tiles indigo" style="background:#299e33">
                            <h2 align="left">{{ count($client) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> Clients</p></b>
                            <img src="{{asset('admin/img/icons/crm.svg')}}" alt="Clients" style="color:purple" />

                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('employer.create') }}'">
                        <div class="icon-tiles info" style="background:#007bff">
                            <h2 align="left">{{ count($employee) ?? 0 }}</h2>
                            <b><p style="margin-top:-20px">Staffs</p></b>
                            <img src="{{asset('admin/img/icons/revenue.svg')}}" alt="Employers" />

                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('vendor.index') }}'">
                        <div class="icon-tiles cyan" style="background:#d5ad2a">
                            <h2 align="left">{{ count($vendor) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> Suppliers</p></b>
                            <img src="{{asset('admin/img/icons/supplier2.svg')}}" alt="Suppliers" />
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('shipper.index') }}'">

                        <div class="icon-tiles teal" style="background: #6610f2">
                            <h2 align="left">{{ count($shipper) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> Shippers</p></b>
                            <img src="{{asset('admin/img/icons/staff.svg')}}" alt="Shippers" />

                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('rfq.index') }}'">
                        <div class="icon-tiles primary" style="background:#20c997">
                            <h2 align="left">{{ count($rfq) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> RFQs</p></b>
                            <img src="{{asset('admin/img/icons/appointment.svg')}}" alt="Client RFQs" />

                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12"  onclick="location.href='{{ route('po.index') }}'" >
                        <div class="icon-tiles blue" style="background:#e83e8c">
                            <h2 align="left">{{ count($po) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> PO</p></b>
                            <img src="{{asset('admin/img/icons/patient.svg')}}" alt="Client POs" />

                        </div>
                    </div> -->
                @elseif(Auth::user()->hasRole('Client'))

                    <!-- <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('client.index') }}'">
                        <div class="icon-tiles indigo" style="background:red">
                            <h2 align="left">1</h2>
                            <b><p style="margin-top:-20px"> Details</p></b>
                            <img src="{{asset('admin/img/icons/staff.svg')}}" alt="Clients" style="color:white" />

                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12"  onclick="location.href='{{ route('contact.index',Auth::user()->email)}}'">
                        <div class="icon-tiles blue" style="background:blue">
                            <h2 align="left">{{ count($contact) }}</h2>
                            <b><p style="margin-top:-20px">Contact</p>
                            <img src="{{asset('admin/img/icons/patient.svg')}}" alt="Client Contact" />
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('rfq.index') }}'">
                        <div class="icon-tiles primary" style="background:#17a2b8">
                            <h2 align="left">{{ count($rfq) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> RFQs</p></b>
                            <img src="{{asset('admin/img/icons/appointment.svg')}}" alt="Client RFQs" />

                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-sm-4 col-12"  onclick="location.href='{{ route('po.index') }}'" >
                        <div class="icon-tiles blue" style="background:#e76b25">
                            <h2 align="left">{{ count($po) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> PO</p></b>
                            <img src="{{asset('admin/img/icons/patient.svg')}}" alt="Client POs" />

                        </div>
                    </div> -->
                @elseif (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD')))

                    <!-- <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('employer.create') }}'">
                        <div class="icon-tiles info" style="background:#299e33">
                            <h2 align="left">1</h2>
                            <b><p style="margin-top:-20px">My Details</p></b>
                            <img src="{{asset('admin/img/icons/patient.svg')}}" alt="My Details" />

                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('vendor.index') }}'">
                        <div class="icon-tiles cyan" style="background:#d5ad2a">
                            <h2 align="left">{{ count($vendor) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> Suppliers</p></b>
                            <img src="{{asset('admin/img/icons/supplier2.svg')}}" style="height:300px; width:450px" alt="Suppliers" />
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('shipper.index') }}'">

                        <div class="icon-tiles teal" style="background:#6610f2">
                            <h2 align="left">{{ count($shipper) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> Shippers</p></b>
                            <img src="{{asset('admin/img/icons/staff.svg')}}" alt="Shippers" />

                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('rfq.index') }}'">
                        <div class="icon-tiles primary" style="background:#9d063b">
                            <h2 align="left">{{ count($rfq) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> RFQs</p></b>
                            <img src="{{asset('admin/img/icons/appointment.svg')}}" alt="Client RFQs" />

                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('po.index') }}'">
                        <div class="icon-tiles blue" style="background:#e76b25">


                            <h2 align="left">{{count($po) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> POs</p></b>

                            <img src="{{asset('admin/img/icons/revenue.svg')}}" alt="Purchase Order" />

                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('get-issues') }}'">
                        <div class="icon-tiles teal" style="background:#54bae2">

                            <h2 align="left">{{\App\Issue::where('assigned_to', Auth::id())->count()}}</h2><b><p style="margin-top:-20px">Help Desk</p></b>
                            <img src="{{asset('admin/img/icons/open-email.svg')}}" alt="Help Desk" />
                        </div>
                    </div> -->

                @endif

                @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('Employer') OR (Auth::user()->hasRole('Client')) OR (Auth::user()->hasRole('Contact')) OR
                    (Auth::user()->hasRole('HOD'))))
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                        @if(count($rfq) == 0)
                            <div class="card">
                                <div class="card-body">
                                    <h5><p style="color:red" align="center"> No RFQ was found for

                                            @if (Gate::allows('SuperAdmin', auth()->user()))
                                                All Clients
                                            @else
                                                {{ $company->company_name ?? ' Your Company' }}
                                            @endif
                                        </p>
                                    </h5>
                                </div>
                            </div>
                        @else
                            <div class="table-container">
                                @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) 
                                    OR (Auth::user()->hasRole('Employer')) OR (Auth::user()->hasRole('HOD')))
                                    <div class="card">
                                        <div class="card-body">
    
                                            <form action="{{ route('rfq.gen.report') }}" class="" method="POST" enctype="multipart/form-data">
                                                {{ csrf_field() }}
    
                                                <div class="row gutters">
    
                                                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-6">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-list" style="color:#28a745"></i></span>
                                                                </div>
                                                                <select class="form-control selectpicker" data-live-search="true" required name="product">
                                                                    <option value=""> -- Select Product -- </option>
                                                                    <option value=""></option>
                                                                    @foreach ($filter as $filters)
                                                                        <option data-tokens="{{ $filters->product }}" value="{{ $filters->product ?? old('product') }}">{{ $filters->product ?? old('product') }}</option>
                                                                    @endforeach
                                                                </select>
    
                                                            </div>
    
                                                            @if ($errors->has('product'))
                                                                <div class="" style="color:red">{{ $errors->first('product') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
    
                                                    <div class="col-xl-6 col-lg-6 col-md-6=12 col-sm-12 col-6">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-user" style="color:#28a745"></i></span>
                                                                </div>
                                                                <select class="form-control selectpicker" data-live-search="true" required name="client_id[]" multiple>
                                                                    <option value=" "> -- Select Clients -- </option>
                                                                    <option value=" "></option>
                                                                    @foreach ($client as $comps)
                                                                        @foreach(clis($comps->client_id) as $lis)
                                                                        <option data-tokens="{{ $lis->client_name }}" value="{{ $comps->client_id }}">{{ $lis->client_name }}</option>
                                                                        @endforeach
                                                                    @endforeach
                                                                </select>
    
                                                            </div>
    
                                                            @if ($errors->has('client_id'))
                                                                <div class="" style="color:red">{{ $errors->first('client_id') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
    
                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-2" align="right" style="margin-top: ;">
                                                        <div class="form-group">
                                                            <button class="btn btn-primary" type="submit" title="Click the button to add company details">Download Report</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
    
                                        </div>
                                    </div>
                                @endif
                                <h5 class="table-title">List of Active RFQs </h5>

                                <div class="table-responsive">
                                    <table id="fixedHeader" class="table m-0" style="width:100%">
                                        <thead class="bg-success text-white" >
                                            <tr style="color: white !important;">

                                                <th>#</th>
                                                <th>Status</th>
                                                <th>Client</th>
                                                <th>Client RFQ No</th>
                                                <th>Our Ref No</th>
                                                <th>Description</th>
                                                <th>Total Quote (USD) <br />
                                                    @if(Auth::user()->hasRole('SuperAdmin'))
                                                    (${{ number_format(sumNgnClientRFQ(),2) ?? 0.00 }})
                                                    @else
                                                    (${{ number_format(sumUsdClientRFQCompany($company->company_id),2) ?? 0.00 }})
                                                    @endif

                                                </th>
                                                <th>Total Quote (NGN) <br />
                                                    @if(Auth::user()->hasRole('SuperAdmin'))
                                                        (₦{{ number_format(sumNgnClientRFQNgn(),2) ?? 0.00 }})
                                                    @else
                                                        (₦{{ number_format(sumNgnClientRFQCompanyNgn($company->company_id),2) ?? 0.00 }})
                                                    @endif
                                                </th>
                                                <th>Buyer</th>
                                                <th>Assigned To</th>
                                                <th>Date</th>
                                                <th>Due Date</th>
                                                <th>Files</th>
                                                <th>Line Items</th>
                                                <th>Notes</th>
                                                <th hidden>Mesc Codes</th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php $num =1; ?>
                                            @foreach ($rfq as $rfqs)
                                                <tr>

                                                    <td>{{ $num }}

                                                         <a href="{{ route('rfq.price',$rfqs->refrence_no) }}" title="View RFQ Price Quotation" class="" onclick="">
                                                            <i class="icon-book" style="color:green"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        @if($rfqs->status == 'Quotation Submitted')
                                                            <span class="badge badge-pill badge-info"> {{ $rfqs->status ?? '' }} </span><br>
                                                            @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')))
                                                                <b><a href="{{ route('rfq.send',$rfqs->refrence_no) }}" class="" onclick="return(sendEnq());">
                                                                    Send Status Enq
                                                                </a></b>
                                                            @endif
                                                        @elseif($rfqs->status == 'Received RFQ')
                                                            <span class="badge badge-pill badge-success"> {{ $rfqs->status ?? '' }} </span>

                                                        @elseif($rfqs->status == 'RFQ Acknowledged')
                                                            <span class="badge badge-pill badge-secondary"> {{ $rfqs->status ?? '' }} </span>

                                                        @elseif($rfqs->status == 'Awaiting Pricing')
                                                            <span class="badge badge-pill badge-gray"> {{ $rfqs->status ?? '' }} </span>

                                                        @elseif($rfqs->status == 'Awaiting Shipping')
                                                            <span class="badge badge-pill badge-danger"> {{ $rfqs->status ?? '' }} </span>

                                                        @elseif($rfqs->status == 'Awaiting Approval')
                                                            <span class="badge badge-pill badge-warning"> {{ $rfqs->status ?? '' }} </span>

                                                        @elseif($rfqs->status == 'Approved')
                                                            <span class="badge badge-pill badge-orange"> {{ $rfqs->status ?? '' }} </span>

                                                        @elseif($rfqs->status == 'No Bid')
                                                            <span class="badge badge-pill badge-primary"> {{ $rfqs->status ?? '' }} </span>

                                                        @else
                                                            <span class="badge badge-pill badge-success">{{ $rfqs->status ?? '' }} </span>
                                                        @endif

                                                    </td>

                                                    <td>{{ substr($rfqs->client->client_name, 0,22 ) ?? '' }}</td>
                                                    <td style="width: 50px">{{ $rfqs->rfq_number ?? '' }}</td>
                                                    <td style="width: 50px"><a href="{{ route('rfq.edit', $rfqs->refrence_no) }}" style="color:blue">
                                                        {{ $rfqs->refrence_no ?? '' }} </a>
                                                    </td>
                                                    <td> {{ substr($rfqs->description,0, 50) ?? '' }} </td>
                                                    <td style="width: 50px">
       @if($rfqs->currency == 'NGN' || (float) $rfqs->total_quote < 2)
            {{ 'TBD' ?? '0.00'}}
        @else
            ${{ number_format((float) $rfqs->total_quote, 2) ?? '0.00' }}
        @endif
                                                    </td>
                                                    <td>
        @if($rfqs->currency != 'NGN' || (float) $rfqs->total_quote < 2)
            {{ 'TBD' ?? '0.00'}}
        @else
            ₦{{ number_format((float) $rfqs->total_quote, 2) ?? '0.00' }}
        @endif
                                                    </td>
                                                    @if (Gate::allows('SuperAdmin', auth()->user()))

                                                        <td>
                                                            @foreach (buyers($rfqs->contact_id) as $items)
                                                                <a href="mailto:{{ $items->email}}?subject='Status Of Inquiry For RFQ'" target="_blank" style="color:blue"> {{ $items->first_name . ' '. $items->last_name ?? 'N/A' }}</a>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @foreach (employ($rfqs->employee_id) as $item)
                                                                <a href="mailto:{{ $item->email}}?subject='Status Of Inquiry For RFQ'" target="_blank" style="color:blue"> {{ $item->full_name ?? 'N/A'   }}</a>
                                                            @endforeach
                                                        </td>
                                                    @else
                                                        <td>
                                                            @foreach (buyers($rfqs->contact_id) as $it)
                                                                <a href="mailto:{{ $it->email}}?subject='Status Of Inquiry For RFQ'" target="_blank" style="color:blue">  {{ $it->first_name . ' '. $it->last_name ?? '' }}</a>
                                                            @endforeach
                                                            {{-- <a href="mailto:{{ $rfqs->contact->email}}?subject='Status Of Inquiry For RFQ'" target="_blank" style="color:blue"> {{ $rfqs->contact->last_name ?? 'N/A'   }}</a> --}}
                                                        </td>
                                                        <td>
                                                            @foreach (employ($rfqs->employee_id) as $item)

                                                                <a href="mailto:{{ $item->email}}?subject='Status Of Inquiry For RFQ'" target="_blank" style="color:blue">  {{ $item->full_name ?? '' }}</a>
                                                            @endforeach
                                                            {{-- <a href="mailto:{{ $rfqs->employee->email}}?subject='Status Of Inquiry For RFQ'" target="_blank" style="color:blue"> {{ $rfqs->employee->full_name ?? 'N/A'   }}</a> --}}
                                                        </td>

                                                    @endif
                                                    <td>{{ isset($rfqs->rfq_date) ? date('d-M-Y, H:i', strtotime($rfqs->rfq_date)) : '' }}</td>
        <td style=" {{ (date('Y-m-d', strtotime($rfqs->delivery_due_date)) === now()->format('Y-m-d')) ? 'color:red;' : '' }}">
    {{ isset($rfqs->delivery_due_date) ? date('d-M-Y, H:i', strtotime($rfqs->delivery_due_date)) : '' }}
</td>
        <td>
            @if (file_exists('document/rfq/' . $rfqs->rfq_id . '/'))
                <a class="open-file-modal" data-rfqid="{{ $rfqs->rfq_id }}" href="#">
                    {{ count(scandir('document/rfq/' . $rfqs->rfq_id . '/')) - 2 }}
                </a>
            @else
                0
            @endif
        </td>
                                                    <td>
                                                        <?php $co = countLineItems($rfqs->rfq_id) ?>
                                                        @if($co > 0 )
                                                            <a href="{{ route('line.preview', $rfqs->rfq_id) }}" style="color:blue">{{ $co }}</a>
                                                        @else
                                                        @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD'))  OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())))
                                                                <a href="{{ route('line.create', $rfqs->rfq_id) }}" style="color:blue">{{ $co }} </a>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
    <a href="#" class="open-note-modal" data-rfqid="{{ $rfqs->rfq_id }}">Notes</a>
</td>
                                                    <td hidden>
                                                        <?php $mesc = getMescCodes($rfqs->rfq_id) ?>
                                                        <p>
                                                        @foreach ($mesc as $mesc_no)
                                                        {{ $mesc_no->mesc_code }} ,
                                                        @endforeach
                                                        </p>
                                                    </td>
                                                </tr>
                                                <?php $num++; ?>
                                            @endforeach

                                        </tbody>
                                    </table>

<div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="commonModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commonModalLabel">Notes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Content will be dynamically updated here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="fileModal" tabindex="-1" role="dialog" aria-labelledby="fileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileModalLabel">Files</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="fileModalBody">
                <!-- Content will be dynamically updated here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
                                </div>

                            </div>
                        @endif
                    </div>
                @elseif(Auth::user()->hasRole('Shipper'))
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        @if(count($rfq) == 0)
                            <div class="card">
                                <div class="card-body">
                                    <h4><p style="color:red" align="center"> No RFQ was found
                                        </p>
                                    </h4>
                                </div>
                            </div>
                        @else
                            <div class="table-container">
                                <h5 class="table-title">List of Active RFQs
                                </h5>
                                <div class="table-responsive">
                                    <table id="fixedHeader" class="table">
                                        <thead class="bg-warning text-white">
                                            <tr>
                                                <th>S/N</th>
                                                <th>Ref Nos</th>
                                                <th>Product</th>
                                                <th>Sumbission Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php $num =1; ?>
                                            @foreach ($rfq as $rfqs)
                                                <tr>
                                                    @php $sh = gettingShipQuote($rfqs->rfq_id, $shipper->shipper_id)    @endphp
                                                    <td>{{ $num }}</td>

                                                    <td>{{ $rfqs->refrence_no ?? '' }}</td>
                                                    <td><a href="{{ route('rfq.details',$rfqs->refrence_no) }}" title="View RFQ Details" class="" onclick="return(confirmToDetails());">

                                                        {{ substr($rfqs->product,0, 40) ?? '' }}...</a></td>
                                                    <td>{{ $rfqs->shipper_submission_date ?? '' }}</td>

                                                    <td>

                                                        @if(count($sh) < 1)
                                                            <a href="{{ route('rfq.shipper.quote',$rfqs->rfq_id) }}" class="btn btn-success" onclick="return(confirmToDetails());">
                                                                <i class="icon-list" style="color:green"></i> Submit Quote
                                                            </a>
                                                        @else

                                                            <a href="{{ route('ship.quote.show',$rfqs->rfq_id)}}" class="btn btn-primary" onclick="return(confirmToDetails());">
                                                                Preview Quote
                                                            </a>

                                                        @endif
                                                    </td>
                                                </tr><?php $num++; ?>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        @endif

                    </div>
                @elseif(Auth::user()->hasRole('Supplier'))
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        @if(count($line_item) == 0)
                            <div class="card">
                                <div class="card-body">
                                    <h4><p style="color:red" align="center"> No Active RFQ was found
                                        </p>
                                    </h4>
                                </div>
                            </div>
                        @else
                            <div class="table-container">
                                <h5 class="table-title">List of Active RFQs
                                </h5>

                                <div class="table-responsive">
                                    <table id="fixedHeader" class="table">
                                        <thead class="bg-success text-white">
                                            <tr>
                                                <th>S/N</th>
                                                <th>Product</th>
                                                <th>Ref Nos</th>
                                                <th>Sumbission Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $num =1; ?>
                                            @foreach ($line_item as $line)
                                                @foreach (gettingRFQ($line->rfq_id) as $rfqs)
                                                    <?php $see = countinfLineItems($rfqs->rfq_id, $vendor->vendor_id);
                                                    if($see > 0 ){ ?>
                                                        <tr>
                                                            <td>{{ $num }}</td>
                                                            @php
                                                            $co = gettingSupQuote($rfqs->rfq_id, $vendor->vendor_id)    @endphp
                                                            <td><a href="{{ route('rfq.details',$rfqs->refrence_no) }}" title="View RFQ Details" class="" onclick="return(confirmToDetails());">
                                                                {{ substr($rfqs->product,0, 40) ?? '' }}...</a></td>
                                                            <td>
                                                                {{ $rfqs->refrence_no ?? '' }}
                                                            </td>
                                                            <td>{{ $rfqs->shipper_submission_date ?? '' }}</td>
                                                            <td>
                                                                @if(count($co) > 0)

                                                                    <a href="{{ route('line.list', $rfqs->rfq_id)}}" class="btn btn-primary" onclick="return(confirmToDetails());">
                                                                        Preview Quote
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('rfq.supplier.quote', $rfqs->rfq_id)}}" class="btn btn-success" onclick="return(confirmToDetails());">
                                                                        Submit Quote
                                                                    </a>
                                                                @endif

                                                            </td>
                                                        </tr><?php $num++;
                                                    }else{

                                                    } ?>
                                                @endforeach
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        @endif

                    </div>
                @elseif(Auth::user()->hasRole('Warehouse User'))
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @if(count($inventory) == 0)
                        <div class="card">
                            <div class="card-body">
                                <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                            </div>
                        </div>
                    @else
                        <div class="table-container">
                            <h5 class="table-title">
                                @if(AUth::user()->hasRole('Warehouse User'))
                                    List of all Inventories for {{ $rest->name }}
                                @else

                                @endif
                            </h5>

                            <div class="table-responsive">
                                <table id="fixedHeader" class="table">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>S/N</th>
                                            <th>Material Number </th>
                                            <th> OEM </th>
                                            <th> OEM Part Number</th>
                                            <th> Storage Location </th>
                                            <th> Quantity </th>
                                            <th> Material Condition </th>
                                            <th> Entered By </th>
                                            <th> Approved By </th>
                                            <th> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $num =1; ?>
                                        @foreach ($inventory as $inventories)
                                            <tr>

                                                <td>{{ $num }}</td>
                                                <td>{{ $inventories->material_number ?? '' }}</td>
                                                <td>{{ $inventories->oem ?? '' }}</td>
                                                <td>{{ $inventories->oem_part_number ?? '' }}</td>
                                                <td>{{ $inventories->storage_location ?? '' }}</td>
                                                <td>{{ $inventories->quantity_location ?? '' }}</td>
                                                <td>{{ $inventories->material_condition ?? '' }}</td>
                                                <td>
                                                    {{ $inventories->user_email ?? '' }}
                                                </td>
                                                <td>
                                                    {{ $inventories->approved_by ?? '' }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('inventory.edit',$inventories->inventory_id) }}" title="Edit The Industry" class="" onclick="return(confirmToEdit());">
                                                        <i class="icon-edit" style="color:blue"></i>
                                                    </a>
                                                    <a href="{{ route('inventory.delete',$inventories->inventory_id) }}" title="View The Inventory" class="">
                                                        <i class="icon-delete" style="color:red"></i>
                                                    </a>

                                                    <a href="{{ route('inventory.details',$inventories->inventory_id) }}" title="View The Inventory" class="">
                                                        <i class="icon-list" style="color:green"></i>
                                                    </a>
                                                </td>
                                            </tr><?php $num++; ?>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    @endif
                </div>
                @else
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    </div>
                @endif

            @endif

        </div>
        <!-- Row end -->

    </div>
</div>
<script>
    $(document).ready(function() {
        $('.open-note-modal').on('click', function(e) {
            e.preventDefault();

            var rfqId = $(this).data('rfqid');
            var modal = $('#commonModal');
            var getNoteUrl = 'https://scm.tagenergygroup.net/getnote.php';

            // Make an Ajax request to fetch the note content from the endpoint
            $.ajax({
                url: getNoteUrl, 
                type: 'POST',
                data: { rfq_id: rfqId },
                success: function(data) {
                    // Update the modal body with the fetched note content
                    modal.find('.modal-body').html(data);
                },
                error: function() {
                    // Handle error if needed
                },
                complete: function() {
                    // Open the modal after content is loaded
                    modal.modal('show');
                }
            });
        });
    });
</script>
<script>
    // Wait for the document to be ready 
    $(document).ready(function() {
        // Attach a click event handler to elements with the class 'open-file-modal'
        $('.open-file-modal').on('click', function(e) {
            // Prevent the default click behavior
            e.preventDefault();
    
            // Get the value of 'rfqid' attribute from the clicked element
            var rfqId = $(this).data('rfqid');
    
            // Get a reference to the modal element with the ID 'fileModal'
            var modal = $('#fileModal');
    
            // Specify the URL for the Ajax request
            var getFilesUrl = 'https://scm.tagenergygroup.net/getfile.php';
    
            // Make an Ajax request to fetch the files content from the endpoint
            $.ajax({
                url: getFilesUrl,
                type: 'POST',
                data: { rfq_id: rfqId },
                dataType: 'json', // Specify the expected data type
                success: function(response) {
                    // Update the modal body with the fetched files content
                    modal.find('.modal-body').html('');
                    modal.find('.modal-body').append('<p>Directory: ' + response.directory + '</p><ul>');
                    
                    // Iterate through the 'files' array in the response and append links
                    $.each(response.files, function(index, file) {
                        modal.find('.modal-body').append('<li><a href="' + response.directory + file + '" target="_blank">' + file + '</a></li>');
                    });
                    
                    modal.find('.modal-body').append('</ul>');
                },
                error: function() {
                    // Handle error if needed
                },
                complete: function() {
                    // Open the modal after content is loaded
                    modal.modal('show');
                }
            });
        });
    });
</script>
@endsection
