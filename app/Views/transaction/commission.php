<div class="user-container container">
    <!-- Sidebar -->
    <?=view('sidebar');?>
    <!-- End Sidebar -->
    <div class="user-content">
        <!-- User Account -->
        <?=view('useraccount');?>
        <!-- End User Account -->
        <div class="user-margin">
            <div class="tab-nav tabNav">
                <div class="cur" target="#downline-tab-pane"><?=lang('Nav.affdownline');?></div>
                <div target="#affcomm-tab-pane"><?=lang('Nav.affcomm');?></div>
                <div target="#afflb-tab-pane"><?=lang('Nav.afflb');?></div>
            </div>
            <div class="tabContent" id="downline-tab-pane">
                <?=form_open('',['class'=>'filter-form filterForm','novalidate'=>'novalidate']);?>
                    <div class="input-wrap">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><?=lang('Input.level');?></div>
                            </div>
                            <div class="select-wrap">
                                <select class="form-select customSelect" name="level">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn" value="<?=lang('Nav.submit');?>">
                <?=form_close();?>
                <div class="table-wrap">
                    <table id="downlineTable" class="table table-history w-100" style="min-width:300px">
                        <thead>
                        <tr>
                        <td><?=lang('Label.numdownline');?></td>
                        <td><?=lang('Input.username');?></td>
                        <td><?=lang('Label.action');?></td>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="tabContent" id="affcomm-tab-pane" style="display:none;">
                <?=form_open('',['class'=>'filter-form filterForm','novalidate'=>'novalidate']);?>
                    <div class="input-wrap">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><?=lang('Input.startdate');?></div>
                            </div>
                            <input type="text" class="form-control" name="start" value="<?=date('Y-m-d');?>" readonly required>
                        </div>
                    </div>
                    <div class="input-wrap">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><?=lang('Input.enddate');?></div>
                            </div>
                            <input type="text" class="form-control" name="end" value="<?=date('Y-m-d');?>" readonly required>
                        </div>
                    </div>
                    <input type="submit" class="btn" value="<?=lang('Nav.submit');?>">
                <?=form_close();?>		
                <div class="table-wrap">
                    <table id="afflogTable" class="table table-history w-100" style="min-width:600px">
                        <thead>
                            <tr>
                            <td><?=lang('Label.createdate');?></td>
                            <td><?=lang('Input.game');?></td>
                            <td><?=lang('Label.affiliate');?></td>
                            <td><?=lang('Label.chip');?></td>
                            <td><?=lang('Label.cash');?></td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="tabContent" id="afflb-tab-pane" style="display:none;">
                <div class="box-black">
                    <p><span><?=lang('Label.thisweekwinlose');?>:</span><span class="actualWinlose">0.00</span></p>
                    <p><span><?=lang('Label.thisweekearn');?>:</span><span><?=$_ENV['currencyCode'];?> <span class="actualLossRebate">0.00</span></span></p>
                    <p><span><?=lang('Label.totalearn');?>:<br>(3% <?=lang('Label.basedownlineloss');?>)</span><span><?=$_ENV['currencyCode'];?> <span class="actualLossRebate">0.00</span></span></p>
                    <div class="d-flex justify-content-end">
                        <a class="btn" onclick="affLossRebateSettlement();"><?=lang('Nav.claimnow');?></a>
                    </div>
                </div>
                <?=form_open('',['class'=>'filter-form filterForm','novalidate'=>'novalidate']);?>
                    <div class="input-wrap">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><?=lang('Input.startdate');?></div>
                            </div>
                            <input type="text" class="form-control" name="start" value="<?=date('Y-m-d',strtotime("-7 days"));?>" readonly required>
                        </div>
                    </div>
                    <div class="input-wrap">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><?=lang('Input.enddate');?></div>
                            </div>
                            <input type="text" class="form-control" name="end" value="<?=date('Y-m-d',strtotime("-1 days"));?>" readonly required>
                        </div>
                    </div>
                    <div class="input-wrap">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><?=lang('Input.dateby');?></div>
                            </div>
                            <div class="select-wrap">
                                <select class="form-select customSelect" name="dateby">
                                    <option value="1"><?=lang('Label.createdate');?></option>
                                    <option value="0"><?=lang('Label.approvedate');?></option>
                                    <option value="2"><?=lang('Label.enddate');?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn" value="Submit">
                <?=form_close();?>
                <div class="table-wrap">
                    <table id="afflblogTable" class="table table-history w-100" style="min-width:600px">
                        <thead>
                            <tr>
                            <td><?=lang('Label.createdate');?></td>
                            <td><?=lang('Label.maxeffectdays');?>/#ID</td>
                            <td><?=lang('Label.affloserebate');?></td>
                            <td><?=lang('Label.cash');?></td>
                            <td><?=lang('Label.chip');?></td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>		
    </div>
</div>
<link rel="stylesheet" href="<?=base_url('../assets/vendors/datatable/datatables.min.css');?>">
<script src="<?=base_url('../assets/vendors/datatable/datatables.min.js');?>"></script>
<script type="text/javascript" src="<?=base_url('../assets/js/table_lang.js');?>"></script>
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    $('.user-nav a[data-page=commission]').addClass("cur");

    if( '<?=$_SESSION['lang']?>' == 'my' ) {
        langs = malay;
    } else if( '<?=$_SESSION['lang']?>' == 'cn' ) {
        langs = chinese;
    } else if( '<?=$_SESSION['lang']?>' == 'zh' ) {
        langs = tradchinese;
    } else if( '<?=$_SESSION['lang']?>' == 'th' ) {
        langs = thai;
    } else if( '<?=$_SESSION['lang']?>' == 'vn' ) {
        langs = viet;
    } else {
        langs = english;
    }

    airdatepicker();

    const downlineTable = $('#downlineTable').DataTable({
        dom: "<'row'<'col-12 overflow-auto'tr>>",
        language: langs,
        ordering: false,
        paging: false,
        deferRender: true,
        serverSide: true,
        processing: true,
        destroy: true,
        ajax: function(data, callback, settings) {
            const lvl = $('#downline-tab-pane .filterForm [name=level]').val();
            
            var payload = JSON.stringify({
                level: lvl
            });
            $.ajax({
                url: '/list/affiliate/downline',
                type: 'post',
                data: payload,
                contentType:"application/json; charset=utf-8",
                dataType:"json",
                success: function(res){
                    if (res.code !== 1) {
                        // alert(res.message);
                        callback({
                            data: []
                        });

                        return;
                    } else {
                        callback({
                            data: res.data
                        });
                    }
                    return;
                }
            });
        },
    });

    $('#downline-tab-pane .filterForm').off().on('submit', function(e) {
        e.preventDefault();

        if (this.checkValidity() !== false) {
            downlineTable.draw();
        }
    });

    const downlineEvent = document.querySelector('[target="#downline-tab-pane"]');
    downlineEvent.addEventListener('click', function (event) {
        event.target // newly activated tab
        event.relatedTarget // previous active tab
        $('#downlineTable').DataTable().ajax.reload(null,false);
    });

    const affcommEvent = document.querySelector('[target="#affcomm-tab-pane"]');
    affcommEvent.addEventListener('click', function (event) {
        event.target // newly activated tab
        event.relatedTarget // previous active tab
        
        var pageindex = 1, debug = false;
        const afflogTable = $('#afflogTable').DataTable({
            dom: "<'row'<'col-12 overflow-auto'tr>>" + "<'row mt-3'<'col-xl-6 col-lg-6 col-md-6 col-12'i><'col-xl-6 col-lg-6 col-md-6 col-12'p>>",
            language: langs,
            ordering: false,
            deferRender: true,
            serverSide: true,
            processing: true,
            destroy: true,
            ajax: function(data, callback, settings) {
                if (settings._iRecordsTotal == 0) {
                    pageindex = 1;
                } else {
                    var pageindex = settings._iDisplayStart/settings._iDisplayLength + 1;
                }

                const fromdate = $('#affcomm-tab-pane .filterForm [name=start]').val();
                const todate = $('#affcomm-tab-pane .filterForm [name=end]').val();
                
                var payload = JSON.stringify({
                    pageindex: pageindex,
                    rowperpage: data.length,
                    start: fromdate,
                    end: todate
                });
                $.ajax({
                    url: '/list/affiliate/history',
                    type: 'post',
                    data: payload,
                    contentType:"application/json; charset=utf-8",
                    dataType:"json",
                    success: function(res){
                        if (res.code !== 1) {
                            // alert(res.message);
                            callback({
                                recordsTotal: 0,
                                recordsFiltered: 0,
                                data: []
                            });

                            return;
                        } else {
                            callback({
                                recordsTotal: res.totalRecord,
                                recordsFiltered: res.totalRecord,
                                data: res.data
                            });
                        }
                        return;
                    }
                });
            },
            drawCallback: function(oSettings, json) {
                $('#afflogTable tbody tr td.dataTables_empty').removeClass('text-end');
                $('#afflogTable tbody tr').find('td:nth-child(5)').addClass('text-end');

                var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
                var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                    return new bootstrap.Popover(popoverTriggerEl)
                });
            },
            // aoColumnDefs: [{
            //     aTargets: [4],
            //     render: function ( data, type, row ) {
            //         return parseFloat(data).toFixed(5).replace(/(\.\d{2})\d*/, "$1").replace(/(\d)(?=(\d{3})+\b)/g, "$1,");
            //     },
            //     fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
            //         parseFloat(sData) < 0 ? $(nTd).addClass('text-danger') : '';
            //     }
            // }]
        });

        $('#affcomm-tab-pane .filterForm').off().on('submit', function(e) {
            e.preventDefault();

            if (this.checkValidity() !== false) {
                afflogTable.draw();
            }
        });
    });

    const afflbEvent = document.querySelector('[target="#afflb-tab-pane"]');
    afflbEvent.addEventListener('click', function (event) {
        event.target // newly activated tab
        event.relatedTarget // previous active tab
        
        affLossRebateListing();

        var pageindex = 1, debug = false;
        const afflblogTable = $('#afflblogTable').DataTable({
            dom: "<'row'<'col-12 overflow-auto'tr>>" + "<'row mt-3'<'col-xl-6 col-lg-6 col-md-6 col-12'i><'col-xl-6 col-lg-6 col-md-6 col-12'p>>",
            language: langs,
            ordering: false,
            deferRender: true,
            serverSide: true,
            processing: true,
            destroy: true,
            ajax: function(data, callback, settings) {
                if (settings._iRecordsTotal == 0) {
                    pageindex = 1;
                } else {
                    var pageindex = settings._iDisplayStart/settings._iDisplayLength + 1;
                }

                const fromdate = $('#afflb-tab-pane .filterForm [name=start]').val();
                const todate = $('#afflb-tab-pane .filterForm [name=end]').val();
                const dateby = $('#afflb-tab-pane .filterForm [name=dateby]').val();
                
                var payload = JSON.stringify({
                    pageindex: pageindex,
                    rowperpage: data.length,
                    start: fromdate,
                    end: todate,
                    dateby: dateby
                });
                $.ajax({
                    url: '/list/affiliate/loss-rebate/history',
                    type: 'post',
                    data: payload,
                    contentType:"application/json; charset=utf-8",
                    dataType:"json",
                    success: function(res){
                        if (res.code !== 1) {
                            // alert(res.message);
                            callback({
                                recordsTotal: 0,
                                recordsFiltered: 0,
                                data: []
                            });

                            return;
                        } else {
                            callback({
                                recordsTotal: res.totalRecord,
                                recordsFiltered: res.totalRecord,
                                data: res.data
                            });
                        }
                        return;
                    }
                });
            },
            drawCallback: function(oSettings, json) {
                $('#afflblogTable tbody tr td.dataTables_empty').removeClass('text-end');
                $('#afflblogTable tbody tr').find('td:nth-child(5)').addClass('text-end');

                var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
                var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                    return new bootstrap.Popover(popoverTriggerEl)
                });
            },
            aoColumnDefs: [{
                aTargets: [3,4],
                render: function ( data, type, row ) {
                    return parseFloat(data).toFixed(5).replace(/(\.\d{2})\d*/, "$1").replace(/(\d)(?=(\d{3})+\b)/g, "$1,");
                },
                fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                    parseFloat(sData) < 0 ? $(nTd).addClass('text-danger') : '';
                }
            }]
        });

        $('#afflb-tab-pane .filterForm').off().on('submit', function(e) {
            e.preventDefault();

            if (this.checkValidity() !== false) {
                afflblogTable.draw();
            }
        });
    });
});

function affLossRebateSettlement()
{
    $.get('/user/affiliate/loss-rebate/settlement', function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            swal.fire("Success!", obj.message, "success").then(() => {
                refreshBalance();
            });
        } else if( obj.code==0 ) {
            swal.fire("Hmmm...", obj.message, "info");
        } else {
            swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
        }
    })
    .done(function() {
        
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}

function affLossRebateListing()
{
    generalLoading();

    $.get('/affiliate/loss-rebate/listing', function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            swal.close();
            // swal.fire("Success!", obj.message, "success").then(() => {
            //     refreshBalance();
            // });

            $('.actualWinlose').html(obj.actualWinlose);
            $('.actualLossRebate').html(obj.actualLoseRebate);
        } else {
            swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
        }
    })
    .done(function() {
        
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}
</script>