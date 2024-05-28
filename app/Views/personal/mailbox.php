<div class="user-container container">
    <!-- Sidebar -->
    <?=view('sidebar');?>
    <!-- End Sidebar -->
    <div class="user-content">
        <!-- User Account -->
        <?=view('useraccount');?>
        <!-- End User Account -->
        <div class="user-margin">
            <div class="table-wrap">
                <table id="msgTable" class="table table-history w-100">
                    <thead>
                    <tr>
                        <td><?=lang('Input.date');?></td>
                        <td><?=lang('Input.title');?></td>
                        <td><?=lang('Input.msg');?></td>
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
    $('.user-nav a[data-page=message]').addClass("cur");

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

    const msgTable = $('#msgTable').DataTable({
        dom: "<'row mb-3'<'col-xl-6 col-lg-6 col-md-6 col-12'l><'col-xl-6 col-lg-6 col-md-6 col-12'f>>" + "<'row'<'col-12 overflow-auto'tr>>" + "<'row mt-3'<'col-xl-6 col-lg-6 col-md-6 col-12'i><'col-xl-6 col-lg-6 col-md-6 col-12'p>>",
        ajax: {
            type : "GET",
            contentType: "application/json; charset=utf-8",
            url: "/list/mail/user",
            dataSrc: function(json) {
                if(json == "no data") {
                    return [];
                } else {
                    return json.data;
                }
            }
        },
        responsive: {
            details: {
                renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                    tableClass: 'w-100 table table-bordered'
                })
            }
        },
        language: langs,
        searching: false,
        processing: true,
        stateSave: true,
        deferRender: true
    });
});
</script>