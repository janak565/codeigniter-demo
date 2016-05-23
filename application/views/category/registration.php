
<?php if(!isset($data['id']) && empty($data['id'])){echo form_open_multipart(SITE_URL.'/user/index');}else{echo form_open_multipart(SITE_URL.'/user/index?id='.$data['id']);}?>
<table border=1; colspan="0"; colspace="0" width="100%">
<?php if(!empty($this->session->flashdata('message'))){ ?>
	<tr>
		<th align="center" colspan=2><?php if(!empty($this->session->flashdata('message'))){ echo $this->session->flashdata('message'); } ?></th>
	</tr>
<?php }?>	
	
	<tr>
		<th align="right" valign="top" width="20%">First Name</th>
		<td>
				<input type="text" name="first_name" class="form_input" id="first_name" value="<?php echo html_escape($data['first_name']);?>"/>
				<?php echo form_error('first_name');?>
		</td>
	</tr>
	<tr>
		<th align="right" valign="top" width="20%">Last Name</th>
		<td>
				<input type="text" name="last_name" class="form_input" id="last_name" value="<?php echo html_escape($data['last_name']);?>"/>
				<?php echo form_error('last_name');?>
		</td>
	</tr>
		<?php if(isset($data['id']) && !empty($data['id'])){?>
	<tr>
		<th align="right" valign="top" width="20%">User Name<br/>(Email Address)</th>
		<td>
				<?php echo html_escape($data['user_name']);?>
		</td>
	</tr>
	<?php }else{?>
		<tr>
			<th align="right" valign="top" width="20%">User Name<br/>(Email Address)</th>
			<td>
					<input type="text" name="user_name" class="form_input" id="user_name" value="<?php echo html_escape($data['user_name']);?>"/>
					<?php echo form_error('user_name');?>
			</td>
		</tr>

	<?php }?>
	<?php if(isset($data['id']) && !empty($data['id'])){?>
	<?php }else{?>
	<tr>
		<th align="right" valign="top" width="20%">Password</th>
		<td>
				<input type="password" name="password" class="form_input" id="password" value="<?php echo html_escape($data['password']);?>"/>
				<?php echo form_error('password');?>
		</td>
	</tr>
	<?php }?>
	<tr>
		<th align="right" valign="top" width="20%">Phone Number</th>
		<td>
				<input type="text" name="phone" class="form_input" id="pnone" value="<?php echo html_escape($data['phone']);?>"/>
				<?php echo form_error('phone');?>
		</td>
	</tr>
	<tr>
		<th align="right" valign="top" width="20%">Photo</th>
		<td>
				<input type="file" name="photo" class="form_input" id="photo" accept="image/*"/>
				<?php echo form_error('photo');?>
		</td>
	</tr>
	<tr>
		<th align="right" valign="top" width="20%">General</th>
		<td>
			<select name="general" id="general">
				<option value="">Select</option>
				<option <?php if($data['general']=='male'){ echo 'selected="selected"'; } ?> value="male">Male</option>
				<option  <?php if($data['general']=='female'){ echo 'selected="selected"'; } ?>value="female">FeMale</option>
			</select>	
				
				<?php echo form_error('general');?>
		</td>
	</tr>
	<tr>
		<th></th>
		<td><input type="submit" class="form_button" name="btn_save" id="btn_save" value="Save"/></td>
	</tr>
</table>	

<?php echo form_close();?>