<script >
    $(function() {
        $('#start-date').datepicker();
        $('#end-date').datepicker();
    });
</script>
<div id="toolbar">
    <div class="row-fluid">
        <div class="span12">
            <div style="margin-bottom: 9px" class="btn-toolbar pull-right">
                <div class="btn-group">
                    <a href="#" class="btn"><i class="icon-shopping-cart"></i> Payments</a>
                </div>
                <div class="btn-group">
                    <a href="#" class="btn"><i class="icon-plus-sign"></i> Add </a>
                    <a href="#" class="btn"><i class="icon-wrench"></i> Edit</a>
                    <a href="#" class="btn btn-danger"><i class="icon-white icon-trash"></i> Remove</a>
                </div>
                <div class="btn-group">
                    <a class="btn dropdown-toggle btn-primary" data-toggle="dropdown" href="#">
                        <i class="icon-th icon-white"></i> 
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#">
                                <i class="icon-th-large"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="icon-th"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="icon-th-list"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="icon-list-alt"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div class="row-fluid">
        <div class="span12">
            <div style="margin-bottom: 9px" class="btn-toolbar">
                <div class="input-prepend input-append pull-left">
                    <span class="add-on">
                        <i class="icon-search"></i>
                    </span>
                    <input type="text" size="16" id="appendedPrependedInput" class="span8">

                </div>

                <div class="input-prepend input-append">

                    <span class="add-on">
                        <strong>From</strong>
                    </span>
                    <input type="text" id="start-date" data-date-format="mm/dd/yy" value="02/16/12" class="span2">
                    <span class="add-on">
                        <strong>To</strong>
                    </span>
                    <input type="text" id="end-date" data-date-format="mm/dd/yy" value="02/16/12" class="span2"> 
                </div>
            </div>
        </div>
        <!-- ================== Content============================================== -->
        <div class="row-fluid">
            <div class="span12 well"> </div>

            <!--<div id="content">
        <input id="test" type="text" data-provide="typeahead" data-url="http://asitha.net/rest/product/nameSearch/"><br>
    
        <table id="tcontent" class="table table-bordered table-striped" data-url="http://asitha.net/rest/product/nameSearch/" data-headers="ID,Product_Names"> 
            <tbody id="tbcontent"></tbody>
         </table>
    </div>-->
        </div>
    </div>
</div>