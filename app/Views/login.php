<main>
    
<nav class="d-block mb-3">
    <a class="d-inline-block text-decoration-none p-3 fs-6" href="<?=base_url();?>"><i class='bx bx-chevrons-left me-1'></i><?=lang('Nav.back');?></a>
</nav>

<figure class="d-block px-5 text-center">
    <img class="w-75 px-xl-5 px-lg-5 px-md-5 p-0" src="<?=base_url('../assets/img/logo/logo.png');?>" alt="<?=$_ENV['company'];?>" title="<?=$_ENV['company'];?>">
</figure>

<?=form_open('', ['class'=>'form-validation loginForm pt-3','novalidate'=>'novalidate']);?>
<div class="input-group mb-3">
    <span class="input-group-text"><i class="bx bx-user"></i></span>
    <input type="text" class="form-control form-control-lg" pattern="^[a-zA-Z0-9]{6,12}$" name="username" id="username" placeholder="<?=lang('Input.username');?>" required>
</div>
<div class="input-group mb-3">
    <span class="input-group-text"><i class="bx bxs-lock"></i></span>
    <input type="password" class="form-control form-control-lg" pattern="^[a-zA-Z0-9]{6,}$" name="password" id="password" placeholder="<?=lang('Input.password');?>" required>
</div>
<div class="d-flex justify-content-between">
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" value="isRememberMe" id="rememberMe">
        <label class="form-check-label" for="rememberMe"><?=lang('Label.rememberme');?></label>
    </div>

    <a class="text-decoration-none" href="<?=base_url('create-account');?>"><?=lang('Nav.createacc');?></a>
</div>
<button type="submit" class="btn btn-login text-uppercase" onclick="isRememberMe();"><?=lang('Nav.login');?></button>
<?=form_close();?>
</main>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    $('.loginForm').on('submit', function(e) {
        e.preventDefault();

        if (this.checkValidity() !== false) {
            generalLoading();

            $('.loginForm [type=submit]').prop('disabled', true);

            var params = {};
            var formObj = $(this).closest("form");
            $.each($(formObj).serializeArray(), function (index, value) {
                params[value.name] = value.value;
            });

            $.post('/user/login', {
                params
            }, function(data, status) {
                const obj = JSON.parse(data);
                if( obj.code==1 ) {
                    window.location.replace("<?=base_url();?>");
                    // checkIfEmptyBankAccount(1);
                } else {
                    swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
                }
            })
            .done(function() {
                $('.loginForm [type=submit]').prop('disabled', false);
            })
            .fail(function() {
                $('.loginForm [type=submit]').prop('disabled', false);
                swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
            });
        }
    });
});

const rmCheck = document.getElementById("rememberMe"),
usernameInput = document.getElementById("username");

if (localStorage.checkbox && localStorage.checkbox !== "") {
    rmCheck.setAttribute("checked", "checked");
    usernameInput.value = localStorage.username;
} else {
    rmCheck.removeAttribute("checked");
    usernameInput.value = "";
}

function isRememberMe()
{
    if (rmCheck.checked && usernameInput.value !== "") {
        localStorage.username = usernameInput.value;
        localStorage.checkbox = rmCheck.value;
    } else {
        localStorage.username = "";
        localStorage.checkbox = "";
    }
}
</script>