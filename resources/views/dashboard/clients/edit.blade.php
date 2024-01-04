<?php $title = 'Edit Clients'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('client.edit',$cli->client_id) }}">Edit Client</a></li>
                <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Add Client</a></li>
                {{-- <li class="breadcrumb-item"><a href="{{ route('client.restore') }}">Bin</a></li> --}}

                <li class="breadcrumb-item">Edit Client</li>
            </ol>
            @include('layouts.logo')
        </div>
        <!-- Page header end -->


        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
                                <div class="card-title">Please fill the below form to update the client details
                                    <a  href="{{ route('client.details',$cli->client_id) }}" class="btn btn-primary" style="float: right">  View Details </a>
                                </div>
							</div>
                            <form action="{{ route('client.update',$cli->client_id) }}" class="" method="POST"  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @include('layouts.alert')
                                <div class="row gutters">
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Company Name</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-list" style="color:#28a745"></i></span>
                                                </div>
                                                <select class="form-control selectpicker" data-live-search="true" required name="company_id">
                                                    @if (Gate::allows('SuperAdmin', auth()->user()))
                                                        <option data-tokens="{{ $cli->company_id }}" value="{{ $cli->company_id }}">
                                                            {{ $cli->company->company_name }}
                                                        </option>
                                                        @foreach ($company as $companies)
                                                            <option data-tokens="{{ $companies->company_id }}" value="{{ $companies->company_id }}">
                                                                {{ $companies->company_name }}
                                                            </option>
                                                        @endforeach
                                                    @elseif(Auth::user()->hasRole('Client'))
                                                        <option data-tokens="{{ $cli->company_id }}" value="{{ $cli->company_id }}">
                                                            {{ $cli->company->company_name }}
                                                        </option>
                                                    @else
                                                        <option data-tokens="{{ $company->company_id }}" value="{{ $company->company_id }}">
                                                            {{ $company->company_name }}
                                                        </option>
                                                    @endif

												</select>
                                            </div>

                                            @if ($errors->has('company_id'))
                                                <div class="" style="color:red">{{ $errors->first('company_id') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Client Name</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-add-to-list" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="client_name" required placeholder="Enter Client Name" type="text"
                                                value="{{ $cli->client_name }}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('client_name'))
                                                <div class="" style="color:red">{{ $errors->first('client_name') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Company Vendor Code</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-add-to-list" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="company_vendor_code" required placeholder="Enter Company Vendor Code" type="text"
                                                value="{{ $cli->company_vendor_code ?? old('company_vendor_code')}}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('company_vendor_code'))
                                                <div class="" style="color:red">{{ $errors->first('company_vendor_code') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Short Code</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-add-to-list" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="short_code" required placeholder="Enter Code" type="text"
                                                value="{{ $cli->short_code }}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('short_code'))
                                                <div class="" style="color:red">{{ $errors->first('short_code') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Client State</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-creative-commons" style="color:#28a745"></i></span>
                                                </div>
                                                <select class="form-control selectpicker" data-live-search="true" required name="state">
                                                    <option value="{{ $cli->state }}"> {{ $cli->state }}</option>
                                                    <option value=""></option>
                                                    <option value="Abuja FCT">Abuja FCT</option>
                                                    <option value="Abia">Abia</option>
                                                    <option value="Adamawa">Adamawa</option>
                                                    <option value="Akwa Ibom">Akwa Ibom</option>
                                                    <option value="Anambra">Anambra</option>
                                                    <option value="Bauchi">Bauchi</option>
                                                    <option value="Bayelsa">Bayelsa</option>
                                                    <option value="Benue">Benue</option>
                                                    <option value="Borno">Borno</option>
                                                    <option value="Cross River">Cross River</option>
                                                    <option value="Delta">Delta</option>
                                                    <option value="Ebonyi">Ebonyi</option>
                                                    <option value="Edo">Edo</option>
                                                    <option value="Ekiti">Ekiti</option>
                                                    <option value="Enugu">Enugu</option>
                                                    <option value="Gombe">Gombe</option>
                                                    <option value="Imo">Imo</option>
                                                    <option value="Jigawa">Jigawa</option>
                                                    <option value="Kaduna">Kaduna</option>
                                                    <option value="Kano">Kano</option>
                                                    <option value="Katsina">Katsina</option>
                                                    <option value="Kebbi">Kebbi</option>
                                                    <option value="Kogi">Kogi</option>
                                                    <option value="Kwara">Kwara</option>
                                                    <option value="Lagos">Lagos</option>
                                                    <option value="Nassarawa">Nassarawa</option>
                                                    <option value="Niger">Niger</option>
                                                    <option value="Ogun">Ogun</option>
                                                    <option value="Ondo">Ondo</option>
                                                    <option value="Osun">Osun</option>
                                                    <option value="Oyo">Oyo</option>
                                                    <option value="Plateau">Plateau</option>
                                                    <option value="Rivers">Rivers</option>
                                                    <option value="Sokoto">Sokoto</option>
                                                    <option value="Taraba">Taraba</option>
                                                    <option value="Yobe">Yobe</option>
                                                    <option value="Zamfara">Zamfara</option>
                                                    <option value="Outside Nigeria">Outside Nigeria</option>
                                                </select>
                                            </div>

                                            @if ($errors->has('state'))
                                                <div class="" style="color:red">{{ $errors->first('state') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Client City</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-location" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="city" required placeholder="Enter City" type="text" value="{{ $cli->city }}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('city'))
                                                <div class="" style="color:red">{{ $errors->first('city') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Phone Number</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-phone" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="phone" required placeholder="Enter Phone" type="text" value="{{ $cli->phone }}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('phone'))
                                                <div class="" style="color:red">{{ $errors->first('phone') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <label for="nameOnCard">Login Email</label>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-mail" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="email" readonly placeholder="Enter Email" type="email" value="{{ $cli->email }}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('email'))
                                                <div class="" style="color:red">{{ $errors->first('email') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Country </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-document-landscape" style="color:#28a745"></i></span>
                                                </div>

                                                <?php
                                                $countryArray = array(
                                                    'NG'=>array('name'=>'NIGERIA','code'=>'234'),
                                                    'AD'=>array('name'=>'ANDORRA','code'=>'376'),
                                                    'AE'=>array('name'=>'UNITED ARAB EMIRATES','code'=>'971'),
                                                    'AF'=>array('name'=>'AFGHANISTAN','code'=>'93'),
                                                    'AG'=>array('name'=>'ANTIGUA AND BARBUDA','code'=>'1268'),
                                                    'AI'=>array('name'=>'ANGUILLA','code'=>'1264'),
                                                    'AL'=>array('name'=>'ALBANIA','code'=>'355'),
                                                    'AM'=>array('name'=>'ARMENIA','code'=>'374'),
                                                    'AN'=>array('name'=>'NETHERLANDS ANTILLES','code'=>'599'),
                                                    'AO'=>array('name'=>'ANGOLA','code'=>'244'),
                                                    'AQ'=>array('name'=>'ANTARCTICA','code'=>'672'),
                                                    'AR'=>array('name'=>'ARGENTINA','code'=>'54'),
                                                    'AS'=>array('name'=>'AMERICAN SAMOA','code'=>'1684'),
                                                    'AT'=>array('name'=>'AUSTRIA','code'=>'43'),
                                                    'AU'=>array('name'=>'AUSTRALIA','code'=>'61'),
                                                    'AW'=>array('name'=>'ARUBA','code'=>'297'),
                                                    'AZ'=>array('name'=>'AZERBAIJAN','code'=>'994'),
                                                    'BA'=>array('name'=>'BOSNIA AND HERZEGOVINA','code'=>'387'),
                                                    'BB'=>array('name'=>'BARBADOS','code'=>'1246'),
                                                    'BD'=>array('name'=>'BANGLADESH','code'=>'880'),
                                                    'BE'=>array('name'=>'BELGIUM','code'=>'32'),
                                                    'BF'=>array('name'=>'BURKINA FASO','code'=>'226'),
                                                    'BG'=>array('name'=>'BULGARIA','code'=>'359'),
                                                    'BH'=>array('name'=>'BAHRAIN','code'=>'973'),
                                                    'BI'=>array('name'=>'BURUNDI','code'=>'257'),
                                                    'BJ'=>array('name'=>'BENIN','code'=>'229'),
                                                    'BL'=>array('name'=>'SAINT BARTHELEMY','code'=>'590'),
                                                    'BM'=>array('name'=>'BERMUDA','code'=>'1441'),
                                                    'BN'=>array('name'=>'BRUNEI DARUSSALAM','code'=>'673'),
                                                    'BO'=>array('name'=>'BOLIVIA','code'=>'591'),
                                                    'BR'=>array('name'=>'BRAZIL','code'=>'55'),
                                                    'BS'=>array('name'=>'BAHAMAS','code'=>'1242'),
                                                    'BT'=>array('name'=>'BHUTAN','code'=>'975'),
                                                    'BW'=>array('name'=>'BOTSWANA','code'=>'267'),
                                                    'BY'=>array('name'=>'BELARUS','code'=>'375'),
                                                    'BZ'=>array('name'=>'BELIZE','code'=>'501'),
                                                    'CA'=>array('name'=>'CANADA','code'=>'1'),
                                                    'CC'=>array('name'=>'COCOS (KEELING) ISLANDS','code'=>'61'),
                                                    'CD'=>array('name'=>'CONGO, THE DEMOCRATIC REPUBLIC OF THE','code'=>'243'),
                                                    'CF'=>array('name'=>'CENTRAL AFRICAN REPUBLIC','code'=>'236'),
                                                    'CG'=>array('name'=>'CONGO','code'=>'242'),
                                                    'CH'=>array('name'=>'SWITZERLAND','code'=>'41'),
                                                    'CI'=>array('name'=>'COTE D IVOIRE','code'=>'225'),
                                                    'CK'=>array('name'=>'COOK ISLANDS','code'=>'682'),
                                                    'CL'=>array('name'=>'CHILE','code'=>'56'),
                                                    'CM'=>array('name'=>'CAMEROON','code'=>'237'),
                                                    'CN'=>array('name'=>'CHINA','code'=>'86'),
                                                    'CO'=>array('name'=>'COLOMBIA','code'=>'57'),
                                                    'CR'=>array('name'=>'COSTA RICA','code'=>'506'),
                                                    'CU'=>array('name'=>'CUBA','code'=>'53'),
                                                    'CV'=>array('name'=>'CAPE VERDE','code'=>'238'),
                                                    'CX'=>array('name'=>'CHRISTMAS ISLAND','code'=>'61'),
                                                    'CY'=>array('name'=>'CYPRUS','code'=>'357'),
                                                    'CZ'=>array('name'=>'CZECH REPUBLIC','code'=>'420'),
                                                    'DE'=>array('name'=>'GERMANY','code'=>'49'),
                                                    'DJ'=>array('name'=>'DJIBOUTI','code'=>'253'),
                                                    'DK'=>array('name'=>'DENMARK','code'=>'45'),
                                                    'DM'=>array('name'=>'DOMINICA','code'=>'1767'),
                                                    'DO'=>array('name'=>'DOMINICAN REPUBLIC','code'=>'1809'),
                                                    'DZ'=>array('name'=>'ALGERIA','code'=>'213'),
                                                    'EC'=>array('name'=>'ECUADOR','code'=>'593'),
                                                    'EE'=>array('name'=>'ESTONIA','code'=>'372'),
                                                    'EG'=>array('name'=>'EGYPT','code'=>'20'),
                                                    'ER'=>array('name'=>'ERITREA','code'=>'291'),
                                                    'ES'=>array('name'=>'SPAIN','code'=>'34'),
                                                    'ET'=>array('name'=>'ETHIOPIA','code'=>'251'),
                                                    'FI'=>array('name'=>'FINLAND','code'=>'358'),
                                                    'FJ'=>array('name'=>'FIJI','code'=>'679'),
                                                    'FK'=>array('name'=>'FALKLAND ISLANDS (MALVINAS)','code'=>'500'),
                                                    'FM'=>array('name'=>'MICRONESIA, FEDERATED STATES OF','code'=>'691'),
                                                    'FO'=>array('name'=>'FAROE ISLANDS','code'=>'298'),
                                                    'FR'=>array('name'=>'FRANCE','code'=>'33'),
                                                    'GA'=>array('name'=>'GABON','code'=>'241'),
                                                    'GB'=>array('name'=>'UNITED KINGDOM','code'=>'44'),
                                                    'GD'=>array('name'=>'GRENADA','code'=>'1473'),
                                                    'GE'=>array('name'=>'GEORGIA','code'=>'995'),
                                                    'GH'=>array('name'=>'GHANA','code'=>'233'),
                                                    'GI'=>array('name'=>'GIBRALTAR','code'=>'350'),
                                                    'GL'=>array('name'=>'GREENLAND','code'=>'299'),
                                                    'GM'=>array('name'=>'GAMBIA','code'=>'220'),
                                                    'GN'=>array('name'=>'GUINEA','code'=>'224'),
                                                    'GQ'=>array('name'=>'EQUATORIAL GUINEA','code'=>'240'),
                                                    'GR'=>array('name'=>'GREECE','code'=>'30'),
                                                    'GT'=>array('name'=>'GUATEMALA','code'=>'502'),
                                                    'GU'=>array('name'=>'GUAM','code'=>'1671'),
                                                    'GW'=>array('name'=>'GUINEA-BISSAU','code'=>'245'),
                                                    'GY'=>array('name'=>'GUYANA','code'=>'592'),
                                                    'HK'=>array('name'=>'HONG KONG','code'=>'852'),
                                                    'HN'=>array('name'=>'HONDURAS','code'=>'504'),
                                                    'HR'=>array('name'=>'CROATIA','code'=>'385'),
                                                    'HT'=>array('name'=>'HAITI','code'=>'509'),
                                                    'HU'=>array('name'=>'HUNGARY','code'=>'36'),
                                                    'ID'=>array('name'=>'INDONESIA','code'=>'62'),
                                                    'IE'=>array('name'=>'IRELAND','code'=>'353'),
                                                    'IL'=>array('name'=>'ISRAEL','code'=>'972'),
                                                    'IM'=>array('name'=>'ISLE OF MAN','code'=>'44'),
                                                    'IN'=>array('name'=>'INDIA','code'=>'91'),
                                                    'IQ'=>array('name'=>'IRAQ','code'=>'964'),
                                                    'IR'=>array('name'=>'IRAN, ISLAMIC REPUBLIC OF','code'=>'98'),
                                                    'IS'=>array('name'=>'ICELAND','code'=>'354'),
                                                    'IT'=>array('name'=>'ITALY','code'=>'39'),
                                                    'JM'=>array('name'=>'JAMAICA','code'=>'1876'),
                                                    'JO'=>array('name'=>'JORDAN','code'=>'962'),
                                                    'JP'=>array('name'=>'JAPAN','code'=>'81'),
                                                    'KE'=>array('name'=>'KENYA','code'=>'254'),
                                                    'KG'=>array('name'=>'KYRGYZSTAN','code'=>'996'),
                                                    'KH'=>array('name'=>'CAMBODIA','code'=>'855'),
                                                    'KI'=>array('name'=>'KIRIBATI','code'=>'686'),
                                                    'KM'=>array('name'=>'COMOROS','code'=>'269'),
                                                    'KN'=>array('name'=>'SAINT KITTS AND NEVIS','code'=>'1869'),
                                                    'KP'=>array('name'=>'KOREA DEMOCRATIC PEOPLES REPUBLIC OF','code'=>'850'),
                                                    'KR'=>array('name'=>'KOREA REPUBLIC OF','code'=>'82'),
                                                    'KW'=>array('name'=>'KUWAIT','code'=>'965'),
                                                    'KY'=>array('name'=>'CAYMAN ISLANDS','code'=>'1345'),
                                                    'KZ'=>array('name'=>'KAZAKSTAN','code'=>'7'),
                                                    'LA'=>array('name'=>'LAO PEOPLES DEMOCRATIC REPUBLIC','code'=>'856'),
                                                    'LB'=>array('name'=>'LEBANON','code'=>'961'),
                                                    'LC'=>array('name'=>'SAINT LUCIA','code'=>'1758'),
                                                    'LI'=>array('name'=>'LIECHTENSTEIN','code'=>'423'),
                                                    'LK'=>array('name'=>'SRI LANKA','code'=>'94'),
                                                    'LR'=>array('name'=>'LIBERIA','code'=>'231'),
                                                    'LS'=>array('name'=>'LESOTHO','code'=>'266'),
                                                    'LT'=>array('name'=>'LITHUANIA','code'=>'370'),
                                                    'LU'=>array('name'=>'LUXEMBOURG','code'=>'352'),
                                                    'LV'=>array('name'=>'LATVIA','code'=>'371'),
                                                    'LY'=>array('name'=>'LIBYAN ARAB JAMAHIRIYA','code'=>'218'),
                                                    'MA'=>array('name'=>'MOROCCO','code'=>'212'),
                                                    'MC'=>array('name'=>'MONACO','code'=>'377'),
                                                    'MD'=>array('name'=>'MOLDOVA, REPUBLIC OF','code'=>'373'),
                                                    'ME'=>array('name'=>'MONTENEGRO','code'=>'382'),
                                                    'MF'=>array('name'=>'SAINT MARTIN','code'=>'1599'),
                                                    'MG'=>array('name'=>'MADAGASCAR','code'=>'261'),
                                                    'MH'=>array('name'=>'MARSHALL ISLANDS','code'=>'692'),
                                                    'MK'=>array('name'=>'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF','code'=>'389'),
                                                    'ML'=>array('name'=>'MALI','code'=>'223'),
                                                    'MM'=>array('name'=>'MYANMAR','code'=>'95'),
                                                    'MN'=>array('name'=>'MONGOLIA','code'=>'976'),
                                                    'MO'=>array('name'=>'MACAU','code'=>'853'),
                                                    'MP'=>array('name'=>'NORTHERN MARIANA ISLANDS','code'=>'1670'),
                                                    'MR'=>array('name'=>'MAURITANIA','code'=>'222'),
                                                    'MS'=>array('name'=>'MONTSERRAT','code'=>'1664'),
                                                    'MT'=>array('name'=>'MALTA','code'=>'356'),
                                                    'MU'=>array('name'=>'MAURITIUS','code'=>'230'),
                                                    'MV'=>array('name'=>'MALDIVES','code'=>'960'),
                                                    'MW'=>array('name'=>'MALAWI','code'=>'265'),
                                                    'MX'=>array('name'=>'MEXICO','code'=>'52'),
                                                    'MY'=>array('name'=>'MALAYSIA','code'=>'60'),
                                                    'MZ'=>array('name'=>'MOZAMBIQUE','code'=>'258'),
                                                    'NA'=>array('name'=>'NAMIBIA','code'=>'264'),
                                                    'NC'=>array('name'=>'NEW CALEDONIA','code'=>'687'),
                                                    'NE'=>array('name'=>'NIGER','code'=>'227'),

                                                    'NI'=>array('name'=>'NICARAGUA','code'=>'505'),
                                                    'NL'=>array('name'=>'NETHERLANDS','code'=>'31'),
                                                    'NO'=>array('name'=>'NORWAY','code'=>'47'),
                                                    'NP'=>array('name'=>'NEPAL','code'=>'977'),
                                                    'NR'=>array('name'=>'NAURU','code'=>'674'),
                                                    'NU'=>array('name'=>'NIUE','code'=>'683'),
                                                    'NZ'=>array('name'=>'NEW ZEALAND','code'=>'64'),
                                                    'OM'=>array('name'=>'OMAN','code'=>'968'),
                                                    'PA'=>array('name'=>'PANAMA','code'=>'507'),
                                                    'PE'=>array('name'=>'PERU','code'=>'51'),
                                                    'PF'=>array('name'=>'FRENCH POLYNESIA','code'=>'689'),
                                                    'PG'=>array('name'=>'PAPUA NEW GUINEA','code'=>'675'),
                                                    'PH'=>array('name'=>'PHILIPPINES','code'=>'63'),
                                                    'PK'=>array('name'=>'PAKISTAN','code'=>'92'),
                                                    'PL'=>array('name'=>'POLAND','code'=>'48'),
                                                    'PM'=>array('name'=>'SAINT PIERRE AND MIQUELON','code'=>'508'),
                                                    'PN'=>array('name'=>'PITCAIRN','code'=>'870'),
                                                    'PR'=>array('name'=>'PUERTO RICO','code'=>'1'),
                                                    'PT'=>array('name'=>'PORTUGAL','code'=>'351'),
                                                    'PW'=>array('name'=>'PALAU','code'=>'680'),
                                                    'PY'=>array('name'=>'PARAGUAY','code'=>'595'),
                                                    'QA'=>array('name'=>'QATAR','code'=>'974'),
                                                    'RO'=>array('name'=>'ROMANIA','code'=>'40'),
                                                    'RS'=>array('name'=>'SERBIA','code'=>'381'),
                                                    'RU'=>array('name'=>'RUSSIAN FEDERATION','code'=>'7'),
                                                    'RW'=>array('name'=>'RWANDA','code'=>'250'),
                                                    'SA'=>array('name'=>'SAUDI ARABIA','code'=>'966'),
                                                    'SB'=>array('name'=>'SOLOMON ISLANDS','code'=>'677'),
                                                    'SC'=>array('name'=>'SEYCHELLES','code'=>'248'),
                                                    'SD'=>array('name'=>'SUDAN','code'=>'249'),
                                                    'SE'=>array('name'=>'SWEDEN','code'=>'46'),
                                                    'SG'=>array('name'=>'SINGAPORE','code'=>'65'),
                                                    'SH'=>array('name'=>'SAINT HELENA','code'=>'290'),
                                                    'SI'=>array('name'=>'SLOVENIA','code'=>'386'),
                                                    'SK'=>array('name'=>'SLOVAKIA','code'=>'421'),
                                                    'SL'=>array('name'=>'SIERRA LEONE','code'=>'232'),
                                                    'SM'=>array('name'=>'SAN MARINO','code'=>'378'),
                                                    'SN'=>array('name'=>'SENEGAL','code'=>'221'),
                                                    'SO'=>array('name'=>'SOMALIA','code'=>'252'),
                                                    'SR'=>array('name'=>'SURINAME','code'=>'597'),
                                                    'ST'=>array('name'=>'SAO TOME AND PRINCIPE','code'=>'239'),
                                                    'SV'=>array('name'=>'EL SALVADOR','code'=>'503'),
                                                    'SY'=>array('name'=>'SYRIAN ARAB REPUBLIC','code'=>'963'),
                                                    'SZ'=>array('name'=>'SWAZILAND','code'=>'268'),
                                                    'TC'=>array('name'=>'TURKS AND CAICOS ISLANDS','code'=>'1649'),
                                                    'TD'=>array('name'=>'CHAD','code'=>'235'),
                                                    'TG'=>array('name'=>'TOGO','code'=>'228'),
                                                    'TH'=>array('name'=>'THAILAND','code'=>'66'),
                                                    'TJ'=>array('name'=>'TAJIKISTAN','code'=>'992'),
                                                    'TK'=>array('name'=>'TOKELAU','code'=>'690'),
                                                    'TL'=>array('name'=>'TIMOR-LESTE','code'=>'670'),
                                                    'TM'=>array('name'=>'TURKMENISTAN','code'=>'993'),
                                                    'TN'=>array('name'=>'TUNISIA','code'=>'216'),
                                                    'TO'=>array('name'=>'TONGA','code'=>'676'),
                                                    'TR'=>array('name'=>'TURKEY','code'=>'90'),
                                                    'TT'=>array('name'=>'TRINIDAD AND TOBAGO','code'=>'1868'),
                                                    'TV'=>array('name'=>'TUVALU','code'=>'688'),
                                                    'TW'=>array('name'=>'TAIWAN, PROVINCE OF CHINA','code'=>'886'),
                                                    'TZ'=>array('name'=>'TANZANIA, UNITED REPUBLIC OF','code'=>'255'),
                                                    'UA'=>array('name'=>'UKRAINE','code'=>'380'),
                                                    'UG'=>array('name'=>'UGANDA','code'=>'256'),
                                                    'US'=>array('name'=>'UNITED STATES','code'=>'1'),
                                                    'UY'=>array('name'=>'URUGUAY','code'=>'598'),
                                                    'UZ'=>array('name'=>'UZBEKISTAN','code'=>'998'),
                                                    'VA'=>array('name'=>'HOLY SEE (VATICAN CITY STATE)','code'=>'39'),
                                                    'VC'=>array('name'=>'SAINT VINCENT AND THE GRENADINES','code'=>'1784'),
                                                    'VE'=>array('name'=>'VENEZUELA','code'=>'58'),
                                                    'VG'=>array('name'=>'VIRGIN ISLANDS, BRITISH','code'=>'1284'),
                                                    'VI'=>array('name'=>'VIRGIN ISLANDS, U.S.','code'=>'1340'),
                                                    'VN'=>array('name'=>'VIET NAM','code'=>'84'),
                                                    'VU'=>array('name'=>'VANUATU','code'=>'678'),
                                                    'WF'=>array('name'=>'WALLIS AND FUTUNA','code'=>'681'),
                                                    'WS'=>array('name'=>'SAMOA','code'=>'685'),
                                                    'XK'=>array('name'=>'KOSOVO','code'=>'381'),
                                                    'YE'=>array('name'=>'YEMEN','code'=>'967'),
                                                    'YT'=>array('name'=>'MAYOTTE','code'=>'262'),
                                                    'ZA'=>array('name'=>'SOUTH AFRICA','code'=>'27'),
                                                    'ZM'=>array('name'=>'ZAMBIA','code'=>'260'),
                                                    'ZW'=>array('name'=>'ZIMBABWE','code'=>'263')
                                                ); ?>
                                                <select class="form-control selectpicker" data-live-search="true" required name="country_code">
                                                    <option data-tokens="{{ $cli->country_code ?? '' }}" value="{{ $cli->country_code ?? '' }}">{{ $cli->country_code ?? '' }}</option>
                                                    <option value=""> </option>
                                                    @foreach ($countryArray as $iten)
                                                        <option data-tokens="{{ $iten["name"] }}" value="{{ $iten["name"] }}">{{ $iten["name"] }}</option>
                                                    @endforeach

                                                </select>
                                            </div>

                                            @if ($errors->has('country_code'))
                                                <div class="" style="color:red">{{ $errors->first('country_code') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Login URL</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-add-to-list" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="login_url" placeholder="Enter Login URL" type="text"
                                                value="{{$cli->login_url ?? old('login_url')}}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('login_url'))
                                                <div class="" style="color:red">{{ $errors->first('login_url') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Vendor Username</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-add-to-list" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="vendor_username" placeholder="Enter Vendor Username" type="text"
                                                value="{{$cli->vendor_username ?? old('vendor_username')}}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('vendor_username'))
                                                <div class="" style="color:red">{{ $errors->first('vendor_username') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Vendor Password</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-add-to-list" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="vendor_password" placeholder="Enter Vendor Password" type="text"
                                                value="{{$cli->vendor_password ?? old('vendor_password')}}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('vendor_password'))
                                                <div class="" style="color:red">{{ $errors->first('vendor_password') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Client Files</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-add-to-list" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="client_file[]" multiple placeholder="" type="file"
                                                value="{{old('client_file')}}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('client_file'))
                                                <div class="" style="color:red">{{ $errors->first('client_file;/') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Client Address</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-my_location" style="color:#28a745"></i></span>
                                                </div>
                                                <textarea class="form-control" id="nameOnCard" name="address" required placeholder="Enter address">{{ $cli->address }}</textarea>
                                            </div>

                                            @if ($errors->has('address'))
                                                <div class="" style="color:red">{{ $errors->first('address') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <input type="hidden" name="client_id" value="{{ $cli->company_id }}">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" align="right">
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit" title="Update Client Details">Update Client Details</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            @if(count($client) == 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                                    </div>
                                </div>
                            @else
                                <div class="table-container">
                                    <h5 class="table-title">List of all Clients</h5>

                                    <div class="table-responsive">
                                        <table id="fixedHeader" class="table">
                                            <thead class="bg-success text-white">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Company Name</th>
                                                    <th> Company Vendor Code </th>
                                                    <th>Client Name</th>
                                                    <th>Short Code</th>
                                                    <th>Email</th>
                                                    <th>Phone Number</th>
                                                    <th>Country Code</th>

                                                        <th> Contact </th>
                                                        <th> RFQ </th>
                                                        <th>PO </th>
                                                    {{-- @endif --}}

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $num =1; ?>
                                                @foreach ($client as $clients)
                                                    <tr>

                                                        <td>{{ $num }}

                                                            @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')))

                                                                <a href="{{ route('client.edit',$clients->client_id) }}" title="Edit Client"class="" title="Edit The CLient" onclick="return(confirmToEdit());">
                                                                    <i class="icon-edit" style="color:blue"></i>
                                                                </a>
                                                                <a href="{{ route('contact.index',$clients->email) }}" title="Ciew or Create Client Contact" class="" title="Client Contact" onclick="return(());">
                                                                    <i class="icon-user" style="color:green"></i>
                                                                </a>

                                                                <a href="{{ route('report.index',$clients->client_id) }}" title="Client Report" class="" onclick="return(());">
                                                                    <i class="icon-layers" style="color:orange"></i>
                                                                </a>
                                                                <a href="{{ route('client.delete',$clients->client_id) }}" title="Delete The Client" class="" onclick="return(confirmToDelete());">
                                                                    <i class="icon-delete" style="color:red"></i>
                                                                </a>
                                                            @endif
                                                            @if(Auth::user()->hasPermissionTo('Edit Client'))
                                                                <a href="{{ route('client.edit',$clients->client_id) }}" title="Edit Client"class="" title="Edit The CLient" onclick="return(confirmToEdit());">
                                                                    <i class="icon-edit" style="color:blue"></i>
                                                                </a>
                                                            @endif
                                                            @if (Auth::user()->hasRole('Employer'))
                                                            <a href="{{ route('rfq.create',$clients->client_id) }}" title="Create Client RFQ" class="" onclick="return(confirmToRFQ());">
                                                                <i class="icon-book" style="color:#6610f2"></i>Create RFQ
                                                            </a>
                                                            @endif

                                                        </td>
                                                        <td>{{ $clients->company->company_name ?? '' }}</td>
                                                        <td>{{ $clients->company_vendor_code ?? '' }} </td>
                                                        <td>{{ $clients->client_name ?? '' }} </td>
                                                        <td>{{ $clients->short_code ?? '' }} </td>
                                                        <td>{{ $clients->email ?? '' }} </td>
                                                        <td>{{ $clients->phone ?? '' }} </td>
                                                        <td>{{ $clients->country_code ?? '' }} </td>

                                                        <td>
                                                            <?php echo $co = countContact($clients->client_id) ?>

                                                        </td>
                                                        <td>  <?php echo $co = countClientRFQ($clients->client_id) ?> </td>
                                                        <td>  <?php echo $co = countClientPO($clients->client_id) ?> </td>
                                                        {{-- @endif --}}
                                                    </tr><?php $num++; ?>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
