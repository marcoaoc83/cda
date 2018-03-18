@extends('layouts.app')

@section('content')


    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Users <small>Some examples to get you started</small></h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Responsive example<small>Users</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Settings 1</a>
                                        </li>
                                        <li><a href="#">Settings 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <p class="text-muted font-13 m-b-30">
                                Responsive is an extension for DataTables that resolves that problem by optimising the table's layout for different screen sizes through the dynamic insertion and removal of columns from the table.
                            </p>

                            <div id="datatable-responsive_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer"><div class="row"><div class="col-sm-6"><div class="dataTables_length" id="datatable-responsive_length"><label>Show <select name="datatable-responsive_length" aria-controls="datatable-responsive" class="form-control input-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div></div><div class="col-sm-6"><div id="datatable-responsive_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control input-sm" placeholder="" aria-controls="datatable-responsive"></label></div></div></div><div class="row"><div class="col-sm-12"><table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info" style="width: 100%;">
                                            <thead>
                                            <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" style="width: 70px;" aria-sort="ascending" aria-label="First name: activate to sort column descending">First name</th><th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" style="width: 69px;" aria-label="Last name: activate to sort column ascending">Last name</th><th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" style="width: 152px;" aria-label="Position: activate to sort column ascending">Position</th><th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" style="width: 67px;" aria-label="Office: activate to sort column ascending">Office</th><th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" style="width: 27px;" aria-label="Age: activate to sort column ascending">Age</th><th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" style="width: 65px;" aria-label="Start date: activate to sort column ascending">Start date</th><th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" style="width: 47px;" aria-label="Salary: activate to sort column ascending">Salary</th><th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" style="width: 35px;" aria-label="Extn.: activate to sort column ascending">Extn.</th><th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" style="width: 151px;" aria-label="E-mail: activate to sort column ascending">E-mail</th></tr>
                                            </thead>
                                            <tbody>

                                            <tr role="row" class="odd">
                                                <td tabindex="0" class="sorting_1">Airi</td>
                                                <td>Satou</td>
                                                <td style="">Accountant</td>
                                                <td style="">Tokyo</td>
                                                <td style="">33</td>
                                                <td style="">2008/11/28</td>
                                                <td style="">$162,700</td>
                                                <td style="">5407</td>
                                                <td style="">a.satou@datatables.net</td>
                                            </tr><tr role="row" class="even">
                                                <td class="sorting_1" tabindex="0">Angelica</td>
                                                <td>Ramos</td>
                                                <td style="">Chief Executive Officer (CEO)</td>
                                                <td style="">London</td>
                                                <td style="">47</td>
                                                <td style="">2009/10/09</td>
                                                <td style="">$1,200,000</td>
                                                <td style="">5797</td>
                                                <td style="">a.ramos@datatables.net</td>
                                            </tr><tr role="row" class="odd">
                                                <td tabindex="0" class="sorting_1">Ashton</td>
                                                <td>Cox</td>
                                                <td style="">Junior Technical Author</td>
                                                <td style="">San Francisco</td>
                                                <td style="">66</td>
                                                <td style="">2009/01/12</td>
                                                <td style="">$86,000</td>
                                                <td style="">1562</td>
                                                <td style="">a.cox@datatables.net</td>
                                            </tr><tr role="row" class="even">
                                                <td class="sorting_1" tabindex="0">Bradley</td>
                                                <td>Greer</td>
                                                <td style="">Software Engineer</td>
                                                <td style="">London</td>
                                                <td style="">41</td>
                                                <td style="">2012/10/13</td>
                                                <td style="">$132,000</td>
                                                <td style="">2558</td>
                                                <td style="">b.greer@datatables.net</td>
                                            </tr><tr role="row" class="odd">
                                                <td class="sorting_1" tabindex="0">Brenden</td>
                                                <td>Wagner</td>
                                                <td style="">Software Engineer</td>
                                                <td style="">San Francisco</td>
                                                <td style="">28</td>
                                                <td style="">2011/06/07</td>
                                                <td style="">$206,850</td>
                                                <td style="">1314</td>
                                                <td style="">b.wagner@datatables.net</td>
                                            </tr><tr role="row" class="even">
                                                <td tabindex="0" class="sorting_1">Brielle</td>
                                                <td>Williamson</td>
                                                <td style="">Integration Specialist</td>
                                                <td style="">New York</td>
                                                <td style="">61</td>
                                                <td style="">2012/12/02</td>
                                                <td style="">$372,000</td>
                                                <td style="">4804</td>
                                                <td style="">b.williamson@datatables.net</td>
                                            </tr><tr role="row" class="odd">
                                                <td class="sorting_1" tabindex="0">Bruno</td>
                                                <td>Nash</td>
                                                <td style="">Software Engineer</td>
                                                <td style="">London</td>
                                                <td style="">38</td>
                                                <td style="">2011/05/03</td>
                                                <td style="">$163,500</td>
                                                <td style="">6222</td>
                                                <td style="">b.nash@datatables.net</td>
                                            </tr><tr role="row" class="even">
                                                <td class="sorting_1" tabindex="0">Caesar</td>
                                                <td>Vance</td>
                                                <td style="">Pre-Sales Support</td>
                                                <td style="">New York</td>
                                                <td style="">21</td>
                                                <td style="">2011/12/12</td>
                                                <td style="">$106,450</td>
                                                <td style="">8330</td>
                                                <td style="">c.vance@datatables.net</td>
                                            </tr><tr role="row" class="odd">
                                                <td class="sorting_1" tabindex="0">Cara</td>
                                                <td>Stevens</td>
                                                <td style="">Sales Assistant</td>
                                                <td style="">New York</td>
                                                <td style="">46</td>
                                                <td style="">2011/12/06</td>
                                                <td style="">$145,600</td>
                                                <td style="">3990</td>
                                                <td style="">c.stevens@datatables.net</td>
                                            </tr><tr role="row" class="even">
                                                <td tabindex="0" class="sorting_1">Cedric</td>
                                                <td>Kelly</td>
                                                <td style="">Senior Javascript Developer</td>
                                                <td style="">Edinburgh</td>
                                                <td style="">22</td>
                                                <td style="">2012/03/29</td>
                                                <td style="">$433,060</td>
                                                <td style="">6224</td>
                                                <td style="">c.kelly@datatables.net</td>
                                            </tr></tbody>
                                        </table></div></div><div class="row"><div class="col-sm-5"><div class="dataTables_info" id="datatable-responsive_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers" id="datatable-responsive_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="datatable-responsive_previous"><a href="#" aria-controls="datatable-responsive" data-dt-idx="0" tabindex="0">Previous</a></li><li class="paginate_button active"><a href="#" aria-controls="datatable-responsive" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button "><a href="#" aria-controls="datatable-responsive" data-dt-idx="2" tabindex="0">2</a></li><li class="paginate_button "><a href="#" aria-controls="datatable-responsive" data-dt-idx="3" tabindex="0">3</a></li><li class="paginate_button "><a href="#" aria-controls="datatable-responsive" data-dt-idx="4" tabindex="0">4</a></li><li class="paginate_button "><a href="#" aria-controls="datatable-responsive" data-dt-idx="5" tabindex="0">5</a></li><li class="paginate_button "><a href="#" aria-controls="datatable-responsive" data-dt-idx="6" tabindex="0">6</a></li><li class="paginate_button next" id="datatable-responsive_next"><a href="#" aria-controls="datatable-responsive" data-dt-idx="7" tabindex="0">Next</a></li></ul></div></div></div></div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->

@endsection
