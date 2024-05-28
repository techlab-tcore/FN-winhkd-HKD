<div class="container">
    <h4 class="pt-3"><?=$secTitle;?></h4>
    <section class="card bg-secondary my-3 shadow">
        <div class="card-body">
            <?=form_open('',['class'=>'form-validation filterForm row gy-2 gx-3 align-items-center','novalidate'=>'novalidate']);?>
            <div class="col-xl-auto col-lg-auto col-md-auto col-12">
                <div class="input-group">
                    <label class="input-group-text"><?=lang('Input.startdate');?></label>
                    <input type="text" class="form-control bg-white" name="start" value="<?=date('Y-m-d');?>" readonly required>
                </div>
            </div>
            <div class="col-xl-auto col-lg-auto col-md-auto col-12">
                <div class="input-group">
                    <label class="input-group-text"><?=lang('Input.enddate');?></label>
                    <input type="text" class="form-control bg-white" name="end" value="<?=date('Y-m-d');?>" readonly required>
                </div>
            </div>
            <div class="col-xl-auto col-lg-auto col-md-auto col-12">
                <button type="submit" class="btn btn-primary w-100"><?=lang('Nav.submit');?></button>
            </div>
            <?=form_close();?>
        </div>
    </section>

    <section class="card bg-secondary my-3 shadow">
        <div class="card-body">
            <table id="scorelogTable" class="w-100 nowrap table table-sm table-bordered table-hover border-dark">
                <thead class="bg-info text-dark">
                <tr>
                <td><?=lang('Label.createdate');?></td>
                <td><?=lang('Input.status');?></td>
                <td><?=lang('Input.game');?></td>
                <td><?=lang('Input.types');?></td>
                <td><?=lang('Input.amount');?></td>
                </tr>
                </thead>
                <tbody class="bg-light text-dark"></tbody>
            </table>
        </div>
    </section>
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

            const fromdate = $('.filterForm [name=start]').val();
            const todate = $('.filterForm [name=end]').val();
            
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

    $('.filterForm').off().on('submit', function(e) {
        e.preventDefault();

        if (this.checkValidity() !== false) {
            scorelogTable.draw();
        }
    });
});
</script>