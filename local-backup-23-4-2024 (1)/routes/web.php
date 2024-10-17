<?php

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
Route::get('/approval', function () {
    $rfq = App\ClientRfq::find(1138);
    $reply = 'tolajide74@gmail.com';
    $line_items = App\LineItem::where(['rfq_id' => 1138])->get();
    $tq = 0;
    foreach($line_items as $line){
        $tq = ($line->quantity * $line->unit_cost) + $tq;
    }
    
    return view('emails.rfq.approval')->with(['rfq' => $rfq, 'reply' => $reply, 'tq' =>$tq]);
});
Route::get('quotation-email', function () {
    $rfq = App\ClientRfq::find(1138);
    $reply = 'tolajide74@gmail.com';
    return view('emails.rfq.quotation')->with(['rfq' => $rfq,'reply' => $reply]);
});
Route::get('/', function () {
    return view('auth.login');
});
Route::post("/user_login", "UserLoginController@userlogin")->name("user.login");

Route::get('/logout', "UserLoginController@logout")->name('admin.logout');

Route::get('/email/resend', "Auth\VerificationController@resend");

Auth::routes(['verify' => true]);
Route::group(["prefix" => "dashboard", "middleware" => ["web", "verified"]], function () {

    Route::group(['middleware' => ['web','role:SuperAdmin|Admin|Employer|HOD|Contact|Shipper|Client|Supplier|Warehouse User']], function () {

        Route::get("/", "DashboardController@index")->name("dashboard.index");

        Route::get("/create-folders", "ClientRFQController@createFolders")->name("createFolders");

        Route::get("/short-code", "ClientRFQController@populateShortCode")->name("shortCode");

        Route::group(["prefix" => "change-password"], function () {
            Route::get("/", "DashboardController@changePassword")->name("pass.change");
            Route::post("/save/{user_id}", "DashboardController@updatePassword")->name("pass.update");
        });
        Route::group(["prefix" => "logs"], function () {
            Route::get("/", "DashboardController@activityLog")->name("log");
        });

        Route::group(["prefix" => "clients"], function () {
            Route::get("/", "ClientController@index")->name("client.index");
            Route::get("/create", "ClientController@create")->name("client.create");
            Route::post("/save", "ClientController@store")->name("client.save");
            Route::get("/edit/{client_id}", "ClientController@edit")->name("client.edit");
            Route::get("/details/{client_id}", "ClientController@show")->name("client.details");
            Route::get("/delete/{client_id}", "ClientController@destroy")->name("client.delete");
            Route::post("/update/{client_id}", "ClientController@update")->name("client.update");
            Route::get("/recyclebin", "ClientController@bin")->name("client.restore");
            Route::get("/restore/{client_id}", "ClientController@restore")->name("client.undelete");
            Route::get("/lists", "ClientController@list")->name("client.list");
            Route::get("/populate", "ClientController@load")->name("client.load");
        });

        Route::group(["prefix" => "client-reports"], function () {
            Route::get("/{client_id}", "ClientReportController@index")->name("report.index");
            Route::get("/edit/{report_id}", "ClientReportController@edit")->name("report.edit");
            Route::post("/save", "ClientReportController@store")->name("report.save");
            Route::post("update/{report_id}", "ClientReportController@update")->name("report.update");
            Route::get("delete/{report_id}", "ClientReportController@destroy")->name("report.delete");
        });

        Route::group(["prefix" => "client-contacts"], function () {
            Route::get("/populate-data", "ClientContactController@loading")->name("contact.loading");
            Route::get("/", "ClientContactController@list")->name("contact.list");
            Route::get("/{email}", "ClientContactController@index")->name("contact.index");
            Route::post("/save", "ClientContactController@store")->name("contact.save");
            Route::get("/edit/{contact_id}", "ClientContactController@edit")->name("contact.edit");
            Route::get("/delete/{contact_id}", "ClientContactController@destroy")->name("contact.delete");
            Route::post("/update/{contact_id}", "ClientContactController@update")->name("contact.update");

        });

        Route::group(["prefix" => "shippers"], function () {
            Route::get("/", "ShipperController@index")->name("shipper.index");
            Route::get("/create", "ShipperController@create")->name("shipper.create");
            Route::post("/save", "ShipperController@store")->name("shipper.save");
            Route::get("/edit/{client_id}", "ShipperController@edit")->name("shipper.edit");
            Route::get("/delete/{client_id}", "ShipperController@destroy")->name("shipper.delete");
            Route::post("/update/{client_id}", "ShipperController@update")->name("shipper.update");
            Route::get("/populate", "ShipperController@load")->name("shipper.load");
            // Route::get("/recyclebin", "ShipperController@bin")->name("client.restore");
            // Route::get("/restore/{client_id}", "ShipperController@restore")->name("client.undelete");
        });

        Route::group(["prefix" => "suppliers"], function () {
            Route::get("/", "VendorController@index")->name("vendor.index");
            Route::get("/create", "VendorController@create")->name("vendor.create");
            Route::post("/save", "VendorController@store")->name("vendor.save");
            Route::get("/edit/{vendor_id}", "VendorController@edit")->name("vendor.edit");
            Route::get("/delete/{vendor_id}", "VendorController@destroy")->name("vendor.delete");
            Route::post("/update/{vendor_id}", "VendorController@update")->name("vendor.update");
            Route::get("/populate", "VendorController@load")->name("vendor.load");
            // Route::get("/recyclebin", "ShipperController@bin")->name("client.restore");
            // Route::get("/restore/{client_id}", "ShipperController@restore")->name("client.undelete");
        });

        Route::group(["prefix" => "rfq-documents"], function () {
            Route::post("/save-file", "LineItemController@saveFiles")->name("saveFiles");
            Route::get("/delete-file/{id}/{vendor_id}", "LineItemController@removeFile")->name("removeFile");
        });

    });

    Route::group(['middleware' => ['role:SuperAdmin|Admin|Warehouse User']], function () {
        Route::group(["prefix" => "users"], function () {
            Route::get("/", "UsersController@index")->name("users.index");
            Route::post("/save", "UsersController@store")->name("users.save");
            Route::get("/edit/{email}", "UsersController@edit")->name("users.edit");
            Route::get("/delete/{email}", "UsersController@destroy")->name("users.delete");
            Route::post("/update/{user_id}", "UsersController@update")->name("users.update");
            Route::get("/recyclebin", "UsersController@bin")->name("users.restore");
            Route::get("/restore/{user_id}", "UsersController@restore")->name("users.undelete");
            Route::get("/suspend/{email}", "UsersController@suspend")->name("users.suspend");
            Route::get("/un-suspend/{email}", "UsersController@unsuspend")->name("users.unsuspend");
        });

        Route::group(["prefix" => "warehouse-users"], function () {
            Route::get("/", "InventoryUserController@index")->name("inventory.user.index");
            Route::post("/save", "InventoryUserController@store")->name("inventory.user.save");
            Route::get("/edit/{email}", "InventoryUserController@edit")->name("inventory.user.edit");
            Route::get("/delete/{email}", "InventoryUserController@destroy")->name("inventory.user.delete");
            Route::post("/update/{user_id}", "InventoryUserController@update")->name("inventory.user.update");

            Route::get("/suspend/{email}", "UsersController@suspend")->name("users.suspend");
            Route::get("/un-suspend/{email}", "UsersController@unsuspend")->name("users.unsuspend");
        });

        Route::group(["prefix" => "inventories"], function () {
            Route::get("/", "InventoryController@index")->name("inventory.index");
            Route::get("/create", "InventoryController@create")->name("inventory.create");
            Route::post("/save", "InventoryController@store")->name("inventory.save");
            Route::get("/edit/{inventory_id}", "InventoryController@edit")->name("inventory.edit");
            Route::get("/delete/{inventory_id}", "InventoryController@destroy")->name("inventory.delete");
            Route::post("/update/{inventory_id}", "InventoryController@update")->name("inventory.update");
            Route::get("/details/{inventory_id}", "InventoryController@show")->name("inventory.details");
        });
    });
    Route::group(['middleware' => ['role:SuperAdmin|Admin']], function () {

        Route::group(["prefix" => "industries"], function () {
            Route::get("/", "IndustryController@index")->name("industry.index");
            Route::post("/save", "IndustryController@store")->name("industry.save");
            Route::get("/edit/{industry_id}", "IndustryController@edit")->name("industry.edit");
            Route::get("/delete/{industry_id}", "IndustryController@destroy")->name("industry.delete");
            Route::post("/update/{industry_id}", "IndustryController@update")->name("industry.update");
            Route::get("/recyclebin", "IndustryController@bin")->name("industry.restore");
            Route::get("/restore/{industry_id}", "IndustryController@restore")->name("industry.undelete");
        });

        Route::group(["prefix" => "warehouses"], function () {
            Route::get("/", "WarehouseController@index")->name("warehouse.index");
            Route::post("/save", "WarehouseController@store")->name("warehouse.save");
            Route::get("/edit/{warehouse_id}", "WarehouseController@edit")->name("warehouse.edit");
            Route::get("/delete/{warehouse_id}", "WarehouseController@destroy")->name("warehouse.delete");
            Route::post("/update/{warehouse_id}", "WarehouseController@update")->name("warehouse.update");
            Route::get("/inventory/{warehouse_id}", "InventoryController@products")->name("warehouse.inventory");
            Route::get("/users/{warehouse_id}", "InventoryUserController@users")->name("warehouse.users");


            Route::get("/recyclebin", "WarehouseController@bin")->name("warehouse.restore");
            Route::get("/restore/{warehouse_id}", "WarehouseController@restore")->name("warehouse.undelete");
        });

        Route::group(["prefix" => "uom"], function () {
            Route::get("/", "RfqMeasurementController@index")->name("unit.index");
            Route::post("/save", "RfqMeasurementController@store")->name("unit.save");
            Route::get("/edit/{unit_id}", "RfqMeasurementController@edit")->name("unit.edit");
            Route::get("/delete/{unit_id}", "RfqMeasurementController@destroy")->name("unit.delete");
            Route::post("/update/{unit_id}", "RfqMeasurementController@update")->name("unit.update");
            Route::get("/recyclebin", "RfqMeasurementController@bin")->name("unit.restore");
            Route::get("/restore/{unit_id}", "RfqMeasurementController@restore")->name("unit.undelete");
        });

        Route::group(["prefix" => "companies"], function () {
            Route::get("/", "CompanyController@index")->name("company.index");
            Route::get("/create", "CompanyController@create")->name("company.create");
            Route::post("/save", "CompanyController@store")->name("company.save");
            Route::get("/details/{email}", "CompanyController@show")->name("company.details");
            Route::get("/edit/{email}", "CompanyController@edit")->name("company.edit");
            Route::get("/delete/{company_id}", "CompanyController@destroy")->name("company.delete");
            Route::post("/update/{email}", "CompanyController@update")->name("company.update");
            Route::get("/recyclebin", "CompanyController@bin")->name("company.restore");
            Route::get("/restore/{company_id}", "CompanyController@restore")->name("company.undelete");
            Route::get("/populate", "CompanyController@load")->name("company.load");
            Route::get("/deleteFile/{company_id}/{filename}", "CompanyController@removeImage")->name("remove.company.file");
        });

        Route::group(["prefix" => "charts"], function () {
            Route::get("/weekly", "ClientRFQController@weekly")->name("rfq.weekly");
            Route::get("/monthly", "ClientRFQController@chart")->name("rfq.chart");
            Route::get("/suppliers", "ClientRFQController@supplierChart")->name("rfq.chart.supplier");
            Route::get("/shippers", "ClientRFQController@shipperChart")->name("rfq.chart.shipper");
            Route::get("/companies", "ClientRFQController@companyChart")->name("rfq.chart.company");

            Route::get("/clients", "ClientRFQController@clientChart")->name("rfq.chart.client");
            Route::get("/employers", "ClientRFQController@employerChart")->name("rfq.chart.employer");
        });

    });

    Route::group(['middleware' => ['role:SuperAdmin|Admin|Employer|Contact|Shipper|Client|HOD|Supplier']], function () {

        Route::group(["prefix" => "request-for-quotation"], function () {

            Route::get("/", "ClientRFQController@index")->name("rfq.index");
            Route::get("/create/{refrence_no}", "ClientRFQController@create")->name("rfq.create");
            Route::post("/save", "ClientRFQController@store")->name("rfq.save");
            Route::get("/details/{refrence_no}", "ClientRFQController@show")->name("rfq.details");
            Route::get("/edit/{refrence_no}", "ClientRFQController@edit")->name("rfq.edit");
            Route::get("/delete/{refrence_no}", "ClientRFQController@destroy")->name("rfq.delete");
            Route::post("/update/{refrence_no}", "ClientRFQController@update")->name("rfq.update");
            Route::get("/list", "ClientRFQController@list")->name("rfq.list");
            Route::get("/send-status-enq/{refrence_no}", "ClientRFQController@sendEnq")->name("rfq.send");
            Route::get("/history", "ClientRFQController@history")->name("rfq.history");
            Route::get("/history/{rfq_id}", "ClientRFQController@singleHistory")->name("rfq.log");
            Route::get("/shipper_quote/{rfq_id}", "ShipperQuoteController@create")->name("rfq.shipper.quote");
            Route::post("/shipper_quote/save", "ShipperQuoteController@store")->name("rfq.shipper.store");
            Route::get("/supplier_quote/{rfq_id}", "SupplierQuoteController@create")->name("rfq.supplier.quote");
            Route::post("/supplier_quote/save", "SupplierQuoteController@store")->name("rfq.supplier.store");
            Route::get("/price_quotation/{refrence_no}", "ClientRFQController@price")->name("rfq.price");
            Route::get("/client/{rfq_id}", "ClientRFQController@clientRfq")->name("client.rfq");
            Route::get("/deleteFile/{rfq_id}/{filename}", "ClientRFQController@removeFile")->name("remove.file");
            Route::get("/deleteAllFiles/{rfq_id}/", "ClientRFQController@removeAllFile")->name("removeall.file");
            Route::post("/submitBreakdown/save", "ClientRFQController@submitBreakdown")->name("breakdown.submit");
            Route::post("/submitQuotation/save", "ClientRFQController@submitQuotation")->name("submit.quote.store");
            Route::get("/deleteImage/{rfq_id}/{filename}", "ClientRFQController@removeImage")->name("remove.image");
            Route::get("/approve-breakdown/{refrence_no}", "ClientRFQController@approveReason")->name("rfq.approve");
            Route::post("/approveBreakdown", "ClientRFQController@approveBreakdown")->name("rfq.approveQuote");
            Route::get("/decline-breakdown/{refrence_no}", "ClientRFQController@disapproveReason")->name("rfq.disapprove");
            Route::post("/decline-breakdown-submit", "ClientRFQController@disapproveBreakdown")->name("rfq.disapproveQuote");

            Route::get('/pdf/{refrence_no}','ClientRFQController@printPriceQuote')->name('print.Quote');

            Route::post("/generate-report", "ClientRFQController@generateReport")->name("rfq.gen.report");
            Route::get("/download-pdf/{rfq_id}", "ClientRFQController@downloadQuote")->name("rfq.downloadQuote");
        });

        Route::group(["prefix" => "purchase-order"], function () {

            Route::get("/", "ClientPOController@index")->name("po.index");
            Route::get("/create/{refrence_no}", "ClientPOController@create")->name("po.create");
            Route::post("/save", "ClientPOController@store")->name("po.save");
            Route::get("/details/{po_id}", "ClientPOController@show")->name("po.details");
            Route::get("/view-pdf/{po_id}", "ClientPOController@printPriceQuote")->name("po.view.pdf");
            Route::get("/pdf/{po_id}", "ClientPOController@downloadQuote")->name("po.pdf");
            Route::get("/edit/{id}", "ClientPOController@edit")->name("po.edit");
            Route::get("/delete/{id}", "ClientPOController@destroy")->name("po.delete");
            Route::post("/update/{id}", "ClientPOController@update")->name("po.update");
            Route::get("/list/{rfq_id}", "ClientPOController@new")->name("po.new.details");
           
            Route::get("/deleteFile/{rfq_id}/{filename}", "ClientPOController@removeFile")->name("remove.po.file");
            Route::get("/deleteAllFiles/{rfq_id}/", "ClientPOController@removeAllFile")->name("removeall.po.file");
            Route::get("/reports", "ClientPOController@report")->name("po.reports");
            Route::get("/reports/client/{client_id}", "ClientPOController@reportClient")->name("po.reports.client");
            Route::post("send/reports/client", "ClientPOController@sendReport")->name("po.send.reports.client");

            Route::post("/send-shipper-quote/save", "ClientPOController@submitSupplierQuotation")->name("submitSupplierQuotation.submit");
        });

        Route::group(["prefix" => "purchase-order-reports"], function () {
            Route::get("/yearly", "ReportController@createReport")->name("po.report.index");
            Route::get("/weekly", "ReportController@weekly")->name("po.report.weekly");
            Route::any("/weekly/fetch", "ReportController@weeklyedit")->name("po.report.weekly.fetch");
            Route::get("/clientPoReport", "ReportController@clientPo")->name("po.report.clientPo");
            Route::get("/monthly", "ReportController@monthly")->name("po.report.monthly");
            Route::post("/yearly/create", "ReportController@searchReport")->name("po.report.year");
            Route::get("/custom", "ReportController@custom")->name("po.report.custom");
            Route::get("/rfq/report", "ReportController@rfq")->name("po.report.rfq");
            Route::POST("/custom/client", "ReportController@customedit")->name("po.report.fetch");
            Route::GET("/custom/ClientPoEdit", "ReportController@ClientPoEdit")->name("po.report.ClientPoEdit");
            Route::get("/send", "ReportController@sendReport")->name("po.report.sendReport");
            Route::post("/sendRfqPoMonthly", "ReportController@sendRfqPoMonthlyReport")->name("po.report.sendRfqPoMonthlyReport");
            Route::post("/sendSaipemReport", "ReportController@sendSaipemReport")->name("po.report.sendSaipemReport");
            Route::post("/sendWeeklyReport", "ReportController@sendWeeklyReport")->name("po.report.sendWeeklyReport");
            Route::post("/sendCustomReport", "ReportController@sendCustomReport")->name("po.report.sendCustomReport");
            Route::post("/sendClientPoReport", "ReportController@sendClientPoReport")->name("po.report.sendClientPoReport");
            Route::post("/sendRfqReport", "ReportController@sendRfqReport")->name("po.report.rfqreport");
        });
        
        Route::group(["prefix" => "products"], function () {
            Route::get("/", "ProductController@index")->name("product.index");
            Route::post("/save", "ProductController@store")->name("product.save");
            Route::get("/edit/{unit_id}", "ProductController@edit")->name("product.edit");
            Route::get("/delete/{unit_id}", "ProductController@destroy")->name("product.delete");
            Route::post("/update/{unit_id}", "ProductController@update")->name("product.update");
            Route::get("/recyclebin", "ProductController@bin")->name("product.restore");
            Route::get("/restore/{unit_id}", "ProductController@restore")->name("product.undelete");
        });

        Route::group(["prefix" => "employees"], function () {

            Route::get("/", "EmployerControllers@index")->name("employer.create");
            Route::post("/save", "EmployerControllers@store")->name("employer.save");
            Route::get("/edit/{employee_id}", "EmployerControllers@edit")->name("employer.edit");
            Route::get("/delete/{employee_id}", "EmployerControllers@destroy")->name("employer.delete");
            Route::post("/update/{employee_id}", "EmployerControllers@update")->name("employer.update");
            Route::get("/suspend/{email}", "EmployerControllers@suspend")->name("employer.suspend");
            Route::get("/un-suspend/{email}", "EmployerControllers@unsuspend")->name("employer.unsuspend");
            Route::get("/populate", "EmployerControllers@load")->name("employer.populate");
            // Route::get("/recyclebin", "CompanyController@bin")->name("company.restore");
            // Route::get("/restore/{user_id}", "CompanyController@restore")->name("company.undelete");
        });

        Route::group(["prefix" => "shipper_quotations"], function () {

            Route::get("/", "ShipperQuoteController@index")->name("ship.quote.index");
            Route::get("/edit/{quote_id}", "ShipperQuoteController@edit")->name("ship.quote.edit");
            // Route::get("/delete/{id}", "ClientPOController@destroy")->name("po.delete");
            Route::post("/update/{quote_id}", "ShipperQuoteController@update")->name("ship.quote.update");
            Route::get("/preview/{rfq_id}", "ShipperQuoteController@show")->name("ship.quote.show");
            Route::get("/pick/{quote_id}", "ShipperQuoteController@choose")->name("ship.quote.chose");
            Route::get("/unpick/{quote_id}", "ShipperQuoteController@unchoose")->name("ship.quote.unchose");
        });

        Route::group(["prefix" => "supplier_quotations"], function () {

            Route::get("/", "SupplierQuoteController@index")->name("sup.quote.index");
            Route::get("/edit/{supplier_quote_id}", "SupplierQuoteController@edit")->name("sup.quote.edit");
            Route::post("/update/{supplier_quote_id}", "SupplierQuoteController@update")->name("sup.quote.update");
            Route::get("/preview/{rfq_id}", "SupplierQuoteController@show")->name("sup.quote.show");
            Route::get("/pick/{supplier_quote_id}", "SupplierQuoteController@choose")->name("sup.quote.chose");
            Route::get("/unpick/{supplier_quote_id}", "SupplierQuoteController@unchoose")->name("sup.quote.unchose");
        });

    });

    Route::group(['middleware' => ['role:SuperAdmin|Admin|HOD|Employer']], function () {

        Route::group(["prefix" => "line-items"], function () {

            Route::get("/", "LineItemController@index")->name("line.index");
            Route::get("/create/{rfq_id}", "LineItemController@create")->name("line.create");
            Route::post("/save", "LineItemController@store")->name("line.save");
            Route::get("/details/{line_id}", "LineItemController@show")->name("line.details");
            Route::get("/edit/{line_id}", "LineItemController@edit")->name("line.edit");
            Route::get("/delete/{line_id}", "LineItemController@destroy")->name("line.delete");
            Route::post("/update/{id}", "LineItemController@update")->name("line.update");
            Route::get("/duplicate/{line_id}", "LineItemController@duplicate")->name("line.duplicate");
            Route::get("/preview/{rfq_id}", "LineItemController@preview")->name("line.preview");
            
        });

        Route::group(["prefix" => "issues"], function () {
            Route::get("/", "IssueController@index")->name("get-issues");
            Route::get("/create-issue", "IssueController@create")->name("get-issue-create-page");
            Route::post("/create-issue", "IssueController@store")->name("issue.create");
            Route::get("/{id}", "IssueController@issueDetails")->name("get-issue-details");
            Route::post("/{id}/update", "IssueController@update")->name("issue.update");
            Route::post("/", "IssueController@destroy")->name("issue.delete");
        });
    });

    Route::group(['middleware' => ['role:Supplier']], function () {

        Route::group(["prefix" => "line-items"], function () {

            Route::get("/list/{rfq_id}", "LineItemController@list")->name("line.list");

        });
    });

});
