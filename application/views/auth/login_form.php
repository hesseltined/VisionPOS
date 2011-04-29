<?php
$username = array(
	'name'	=> 'username',
	'id'	=> 'username',

	'value' => set_value('username')
);

$password = array(
	'name'	=> 'password',
	'id'	=> 'password',

);

$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'style' => 'margin:0;padding:1'
);

$confirmation_code = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8
);

?>

<!-- authorize code  -->
<div class="login_bg">
	<?php echo form_open($this->uri->uri_string())?>
		<div class="graybox size600 alignCenter" id="box_1">
                    <div class="boxBorderTop alignCenter">
                        <span class="boxConerLeftTop">&nbsp;</span>
                        <span class="boxConerRightTop">&nbsp;</span>
                    </div>
                    <div class="boxContent alignCenter">
                        <span class="boxConerLeft">&nbsp;</span>
                        <span class="boxConerRight">&nbsp;</span>
													<div><?php echo $this->lang->line('pre_login_message');?></div>
													
													<?php if(strlen($this->dx_auth->get_auth_error()) > 0):?>
														<div class="msgErr"><p class="error"><?php echo $this->dx_auth->get_auth_error();?></p></div>
													<?php endif;?>
					    
						<p class="colorText">
                            <span class="labelT">User:</span><input type="text" value="Username" onfocus="if(this.value == 'Username') { this.value = '' }" onblur="if(this.value.length == 0) { this.value = 'Username' }" size="30" name="username" id="username">
                        </p>
						
						<div class="hidden-message"><!-- Begain hidden-message 1 -->
                                	<div style="color:red"> <?php echo form_error($username['name']);?> </div>
                        </div><!-- End hidden-message 1 -->
						
                        <p class="colorText">
                            <span class="labelT">Password:</span><input type="password" value="password" onfocus="if(this.value == 'password') { this.value = '' }" onblur="if(this.value.length == 0) { this.value = 'password' }" size="30" name="password" id="password">
                        </p>
						
						<div class="hidden-message"><!-- Begain hidden-message 2 -->
                                	<div style="color:red"> <?php echo form_error($password['name']);?></div><div style="clear:both"></div>
                        </div><br /><!-- End hidden-message 2 -->
						
						<div class="remember-me"> <?php echo form_checkbox($remember);?> <?php echo form_label('Remember me', $remember['id']);?> </div>
						<div class="clear">&nbsp;</div>
						<div style="border:none">
							<?php if ($show_captcha): ?>	
								<div>
									<BR />
									<div>Enter the code exactly as it appears. There is no zero.</div>
									<BR />
									<div class="captcha-image"><?php echo $this->dx_auth->get_captcha_image(); ?></div>
									<BR />
									<div class="confirm-code"><?php echo form_label('<span style="color: red">Confirmation Code</span>', $confirmation_code['id']);?></div>
									<div>
										<?php echo form_input($confirmation_code);?>
										<?php echo form_error($confirmation_code['name']);?>
									</div>
									
								</div>
							<?php endif; ?>	
						</div>
                        <p><input type="submit" value="Login" name="login" id="submit"></p>
						<div class="forgot"> <?php echo anchor($this->dx_auth->forgot_password_uri, 'Forgot password');?> </div>
						<div class="clear">&nbsp;</div>
                    </div>
                    <div class="boxBorderBottom alignCenter">
                        <span class="boxConerLeftBottom">&nbsp;</span>
                        <span class="boxConerRightBottom">&nbsp;</span>
                    </div>
        </div>
	<?php echo form_close();?>
</div>
<!-- end code -->



    	 	
		 