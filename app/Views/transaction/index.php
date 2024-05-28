<div class="container-1300 container history-container">
    <div class="games-nav tabNav">
        <h3><?=strtoupper(lang('Nav.history'));?></h3>
        <ul class="tabNav">
            <li target="#history" class="cur"><span><?=lang('Nav.transferhistory');?></span></li>
            <li target="#scoreLog"><span><?=lang('Nav.scorelog');?></span></li>
        </ul>
    </div>
    <div id="history" class="tabContent">
        <div class="box">
            <?=form_open('',['class'=>'filter-form filterForm','novalidate'=>'novalidate']);?>
                <div class="input-wrap">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><?=lang('Input.types');?></div>
                        </div>
                        <div class="select-wrap">
                        <select class="form-select" name="types">
                            <option value="0"><?=strtoupper(lang('Label.all'));?></option>
                            <option value="1"><?=lang('Label.deposit');?></option>
                            <option value="2"><?=lang('Label.withdrawal');?></option>
                            <option value="3"><?=lang('Label.promotion');?></option>
                            <!-- <option value="5"><?//=lang('Label.affiliate');?></option> -->
                            <option value="6"><?=lang('Label.credittransfer');?></option>
                            <!-- <option value="8"><?//=lang('Label.jackpot');?></option> -->
                            <!-- <option value="9"><?//=lang('Label.fortunetoken');?></option> -->
                            <option value="10"><?=lang('Label.pgtransfer');?></option>
                            <!-- <option value="11"><?//=lang('Label.refcomm');?></option> -->
                            <!-- <option value="12"><?//=lang('Label.depcomm');?></option> -->
                            <!-- <option value="13"><?//=lang('Label.lossrebate');?></option> -->
                            <!-- <option value="14"><?//=lang('Label.affsharereward');?></option> -->
                            <!-- <option value="15"><?//=lang('Label.dailyfreereward');?></option> -->
                            <!-- <option value="16"><?//=lang('Label.affloserebate');?></option> -->
                            <!-- <option value="17"><?//=lang('Label.fortunereward');?></option> -->
                        </select>
                        </div>
                    </div>
                </div>
                <div class="input-wrap">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><?=lang('Input.startdate');?></div>
                        </div>
                        <input type="text" class="form-control" value="<?=date('Y-m-d');?>" name="start" readonly required>
                    </div>
                </div>
                <div class="input-wrap">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><?=lang('Input.enddate');?></div>
                        </div>
                        <input type="text" class="form-control" value="<?=date('Y-m-d');?>" name="end" readonly required>
                    </div>
                </div>
                <button type="submit" class="btn"><?=lang('Nav.submit');?></button>
            <?=form_close();?>	
        </div>
        <div class="box">
            <div class="table-wrap">
                <table id="paymentTable" class="table table-history w-100" style="min-width:600px">
                    <thead>
                        <tr>
                        <td><?=lang('Label.createdate');?></td>
                        <td><?=lang('Input.status');?></td>
                        <td><?=lang('Input.types');?></td>
                        <td><?=lang('Input.amount');?></td>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="scoreLog" class="tabContent" style="display:none;">
        <div class="box">
            <?=form_open('',['class'=>'filter-form scorefilterForm','novalidate'=>'novalidate']);?>
                <div class="input-wrap">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><?=lang('Input.startdate');?></div>
                        </div>
                        <input type="text" class="form-control" value="<?=date('Y-m-d');?>" name="start" readonly required>
                    </div>
                </div>
                <div class="input-wrap">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><?=lang('Input.enddate');?></div>
                        </div>
                        <input type="text" class="form-control" value="<?=date('Y-m-d');?>" name="end" readonly required>
                    </div>
                </div>
                <button type="submit" class="btn"><?=lang('Nav.submit');?></button>
            </form>		
        </div>
        <div class="box">
            <div class="table-wrap">
                <table id="scorelogTable" class="table table-history w-100" style="min-width:600px">
                    <thead>
                        <tr>
                        <td><?=lang('Label.createdate');?></td>
                        <td><?=lang('Input.status');?></td>
                        <td><?=lang('Input.game');?></td>
                        <td><?=lang('Input.types');?></td>
                        <td><?=lang('Input.amount');?></td>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?=base_url('../assets/vendors/datatable/datatables.min.css');?>">
<script src="<?=base_url('../assets/vendors/datatable/datatables.min.js');?>"></script>
<script type="text/javascript" src="<?=base_url('../assets/js/table_lang.js');?>"></script>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
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

    var pageindex = 1, debug = false;
    const paymentTable = $('#paymentTable').DataTable({
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

            const fromdate = $('.filterForm [name=start]').val();
            const todate = $('.filterForm [name=end]').val();
            const paytype = $('.filterForm [name=types]').val();
            
            var payload = JSON.stringify({
                pageindex: pageindex,
                rowperpage: data.length,
                start: fromdate,
                end: todate,
                type: paytype,
            });
            $.ajax({
                url: '/list/transaction/history',
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
            $('#paymentTable tbody tr td.dataTables_empty').removeClass('text-end');
            $('#paymentTable tbody tr').find('td:nth-child(4)').addClass('text-end');

            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
            var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl)
            });
        },
        aoColumnDefs: [{
            aTargets: [3],
            render: function ( data, type, row ) {
                return parseFloat(data).toFixed(5).replace(/(\.\d{2})\d*/, "$1").replace(/(\d)(?=(\d{3})+\b)/g, "$1,");
            }
        }]
    });

    $('.filterForm').off().on('submit', function(e) {
        e.preventDefault();

        if (this.checkValidity() !== false) {
            paymentTable.draw();
        }
    });

    const scorelogTable = $('#scorelogTable').DataTable({
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

            const fromdate = $('.scorefilterForm [name=start]').val();
            const todate = $('.scorefilterForm [name=end]').val();
            
            var payload = JSON.stringify({
                pageindex: pageindex,
                rowperpage: data.length,
                start: fromdate,
                end: todate
            });
            $.ajax({
                url: '/list/game-credit/log',
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
            $('#scorelogTable tbody tr td.dataTables_empty').removeClass('text-end');
            $('#scorelogTable tbody tr').find('td:nth-child(5)').addClass('text-end');

            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
            var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl)
            });
        },
        aoColumnDefs: [{
            aTargets: [4],
            render: function ( data, type, row ) {
                return parseFloat(data).toFixed(5).replace(/(\.\d{2})\d*/, "$1").replace(/(\d)(?=(\d{3})+\b)/g, "$1,");
            },
            fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                parseFloat(sData) < 0 ? $(nTd).addClass('text-danger') : '';
            }
        }]
    });

    $('.scorefilterForm').off().on('submit', function(e) {
        e.preventDefault();

        if (this.checkValidity() !== false) {
            scorelogTable.draw();
        }
    });
});
</script>