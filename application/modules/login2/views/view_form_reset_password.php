<div class="container">
   <div class="col-md-12">
      <ul class="breadcrumb">
         <li><a href="#">Home</a></li>
         <li><?php echo $this->uri->segment(1); ?></li>
      </ul>

   </div>

   <div class="col-md-12">
      <div class="box" id="form_reset_password">
         <form id="form_reset_pass" name="formResetPass" action="#">
            <div class="form-group">
               <label for="lblPassForgot" class="lblPassForgotErr">Pasword Baru Anda </label>
               <input type="password" class="form-control" id="pass_forgot" name="passForgot" placeholder="Mohon Masukkan Password baru anda" required>
            </div>
            <div class="form-group">
               <label for="lblPassForgot2" class="lblPassForgotErr2">Tulis Ulang Password </label>
               <input type="password" class="form-control" id="pass_forgot2" name="passForgot2" placeholder="Mohon tulis ulang password baru anda" required>
               <span id='message'></span>
               <input type="text" id="token_forgot" name="tokenForgot" hidden value="<?php echo $token; ?>">
            </div>
         </form>
         <p class="text-center" style="padding-top: 20px;">
            <button class="btn btn-primary" onclick="resetPassProc()"><i class="fa fa-check"></i> Ok</button>
        </p>    
      </div>
   </div><!-- /.col-md-12 -->
</div><!-- /.container -->