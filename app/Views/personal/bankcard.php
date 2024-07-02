<div class="user-container container">
    <!-- Sidebar -->
    <?=view('sidebar');?>
    <!-- End Sidebar -->
    <div class="user-content">
        <!-- User Account -->
        <?=view('useraccount');?>
        <!-- End User Account -->
        <div class="d-lg-none" style="background-color: #000;">
            <div class="account-bankcard container">
                <div style="border-right: 1px solid #686D76"><a href="<?=base_url('deposit');?>"><i class="icon-deposit"></i><?=strtoupper(lang('Nav.deposit'));?></a></div>
                <div style="border-right: 1px solid #686D76"><a href="<?=base_url('withdrawal');?>"><i class="icon-withdraw"></i><?=strtoupper(lang('Nav.withdrawal'));?></a></div>
                <div><a href="<?=base_url('transaction/history');?>"><i class="icon-history"></i><?=strtoupper(lang('Nav.history'));?></a></div>
            </div>
            <div class="url-wrap">
                <?php if( isset($_SESSION['logged_in']) ): ?>
                <a class="border-bottom" href="<?=base_url('transaction/history');?>"><?=strtoupper(lang('Nav.history'));?></a>
                <a class="border-bottom" href="<?=base_url('user-commission');?>"><?=strtoupper(lang('Nav.commlist'));?></a>
                <a class="border-bottom" href="<?=base_url('user-password');?>"><?=strtoupper(lang('Nav.password'));?></a>
                <a href="<?=base_url('user/logout');?>"><?=strtoupper(lang('Nav.logout'));?></a>
                <?php endif; ?>
            </div>
        </div>
			<div class="user-margin">
				<div class="table-wrap">
					<table id="bcTable" class="table table-history w-100" style="min-width:600px">
                    <thead>
                        <tr>
                        <td><?=lang('Input.accno');?></td>
                        <td><?=lang('Input.accholder');?></td>
                        <td><?=lang('Input.status');?></td>
                        <td><?=lang('Input.primary');?></td>
                        </tr>
                    </thead>
                    <tbody></tbody>
					</table>
				</div>
			</div>
				
			<h3 class="form-title"><?=strtoupper(lang('Nav.addbc'));?></h3>
			<?=form_open('',['class'=>'user-form form-validation addBankCardForm','novalidate'=>'novalidate']);?>
				<div class="form-flex">
					<label class="form-label"><?=lang('Input.bank');?><i>*</i></label>
					<select class="form-control form-select" name="bank" id="bank-list" required></select>
				</div>
				<div class="form-flex">
					<label class="form-label"><?=lang('Input.accholder');?><i>*</i></label>
					<input type="text" class="form-control" name="holder" onkeyup="this.value=this.value.replace(/[^a-zA-Z0-9 ]/g, '')" required>
				</div>
				<div class="form-flex">
					<label class="form-label"><?=lang('Input.accno');?><i>*</i></label>
					<input type="text" class="form-control" name="accno" required>
				</div>
				<div class="form-flex">
					<label class="form-label"></label>
					<input type="submit" class="btn" value="<?=lang('Nav.submit');?>">
				</div>
            <?=form_close();?>
		</div>
	</div>

<link rel="stylesheet" href="<?=base_url('../assets/vendors/datatable/datatables.min.css');?>">
<script src="<?=base_url('../assets/vendors/datatable/datatables.min.js');?>"></script>
<script type="text/javascript" src="<?=base_url('../assets/js/table_lang.js');?>"></script>
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    $('.user-nav a[data-page=bankaccount]').addClass("cur");
    $('.h5-tabbar a[data-page=account]').addClass("cur");

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

    getBankList('bank-list');

    const bcTable = $('#bcTable').DataTable({
        dom: "<'row mb-3'<'col-xl-6 col-lg-6 col-md-6 col-12'l><'col-xl-6 col-lg-6 col-md-6 col-12'f>>" + "<'row'<'col-12 overflow-auto'tr>>" + "<'row mt-3'<'col-xl-6 col-lg-6 col-md-6 col-12'i><'col-xl-6 col-lg-6 col-md-6 col-12'p>>",
        language: langs,
        paging: true,
        deferRender: true,
        processing: true,
        destroy: true,
        ajax: {
            type : "GET",
            contentType: "application/json; charset=utf-8",
            url: '/list/bank-account/user',
            dataSrc: function(json) {
                if(json == "no data") {
                    return [];
                } else {
                    return json.data;
                }
            }
        },
    });

    $('.addBankCardForm').off().on('submit', function(e) {
        e.preventDefault();

        if (this.checkValidity() !== false) {
            $('.addBankCardForm [type=submit]').prop('disabled', true);

            var params = {};
            var formObj = $(this).closest("form");
            $.each($(formObj).serializeArray(), function (index, value) {
                params[value.name] = value.value;
            });
            
            $.post('/user/bank-account/add', {
                params
            }, function(data, status) {
                const obj = JSON.parse(data);
                if( obj.code == 1 ) {
                    swal.fire(obj.message, obj.code, 'success').then(() => {
                        $('#bcTable').DataTable().ajax.reload(null,false);
                    });

                    $('.addBankCardForm').trigger('reset');
                    $('.addBankCardForm [type=submit]').prop('disabled', false);
                } else if( obj.code==39 ) {
                    forceUserLogout();
                } else {
                    swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
                }
            })
            .done(function() {
            })
            .fail(function() {
            });
        }
    });
});

function setDefault(bank,holder,accno,cardno)
{
    generalLoading();

    var params = {};
    params['bank'] = bank;
    params['holder'] = holder;
    params['accno'] = accno;
    params['cardno'] = cardno;

    $.post('/user/bank-account/set-default', {
        params
    }, function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            swal.close();
            $('#bcTable').DataTable().ajax.reload(null,false);
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