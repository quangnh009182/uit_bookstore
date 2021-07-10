<?php session_start() ?>
<?php include('admin/db_connect.php'); ?>
<?php 
if(isset($_SESSION['login_id'])){
	$qry = $conn->query("SELECT * from customers where id = {$_SESSION['login_id']} ");
	foreach($qry->fetch_array() as $k => $v){
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<form action="" id="signup-frm">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="form-group">
			<label for="" class="control-label">Họ Và Tên</label>
			<input type="text" name="name" required="" class="form-control" value="<?php echo isset($name) ? $name : '' ?>">
		</div>
		<div class="form-group">
			<label for="" class="control-label">Số Điện Thoại</label>
			<input type="text" name="contact" required="" class="form-control" value="<?php echo isset($contact) ? $contact : '' ?>">
		</div>
		<div class="form-group">
			<label for="" class="control-label">Địa Chỉ</label>
			<textarea cols="30" rows="3" name="address" required="" class="form-control"><?php echo isset($address) ? $address : '' ?></textarea>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Email</label>
			<input type="email" name="email" required="" class="form-control" value="<?php echo isset($email) ? $email : '' ?>">
		</div>
		<div class="form-group">
			<label for="" class="control-label">Mật Khẩu</label>
			<input type="password" name="password" class="form-control" <?php echo isset($email) ? '' : "required" ?>>
			<?php if(isset($id)): ?>
				<small><i>Để trống ô này nếu bạn không muốn đổi mật khẩu</i></small>
			<?php endif; ?>
		</div>
		<button class="button btn btn-primary btn-sm"><?php echo !isset($id) ? "Tạo Tài Khoản" : "Cập Nhật" ?></button>
		<button class="button btn btn-secondary btn-sm" type="button" data-dismiss="modal">Thoát</button>

	</form>
</div>

<style>
	#uni_modal .modal-footer{
		display:none;
	}
</style>
<script>
	$('#signup-frm').submit(function(e){
		e.preventDefault()
		start_load()
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'admin/ajax.php?action=signup',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#signup-frm button[type="submit"]').removeAttr('disabled').html('Create');

			},
			success:function(resp){
				if(resp == 1){
					location.reload();
				}else{
					$('#signup-frm').prepend('<div class="alert alert-danger">Email already exist.</div>')
					end_load()
				}
			}
		})
	})
</script>