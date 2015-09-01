
	<div id="contact">
		<div class="container">
			<div class="col-xs-24 col-sm-10">
				<?php if (@$errorsAndAlerts){ ?>
					<div class="alert alert-danger" role="alert">
					    We're sorry, there was an error with your submission:
					    <ul>
					        <?php echo $errorsAndAlerts; ?>
					    </ul>
					</div>
					<?php } else if (@$success){ ?>
					<div class="alert alert-success" role="alert">
					  Thank you for contacting Think Before You Launch!
					</div>
				<?php } ?>
				<h3><?php echo htmlencode($homepage_contentRecord['contact_headline']) ?></h3>
				<?php echo $homepage_contentRecord['contact_copy']; ?>
				<form action="#contact" method="post">
					<input type="hidden" name="contact" value="1" />
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" name="name" placeholder="Your Name" value="<?php echo @$_REQUEST['name']; ?>">
					</div>
					<div class="form-group">
						<label for="name">Email Address</label>
						<input type="email" class="form-control" name="email" placeholder="Your Email Address" value="<?php echo @$_REQUEST['email']; ?>">
					</div>
					<div class="form-group">
						<label for="name">Comments/Questions</label>
						<textarea class="form-control" name="comment" placeholder="Your Comments/Questions"><?php echo @$_REQUEST['comment']; ?></textarea>
					</div>
					<button type="submit" class="btn btn-default">Submit</button>
				</form>
				<hr class="visible-xs" />
			</div>
			<div class="col-xs-24 col-sm-14">
				<h3><?php echo htmlencode($homepage_contentRecord['learn_more_headline']) ?></h3>
				<?php echo $homepage_contentRecord['learn_more_copy']; ?>
				<?php if($homepage_contentRecord['learn_more_link_url']){ ?>
					<a href="<?php echo htmlencode($homepage_contentRecord['learn_more_link_url']) ?>"><?php echo htmlencode($homepage_contentRecord['learn_more_link_copy']) ?> &gt;</a>
				<?php } ?>
			</div>
		</div>
	</div>
	<div id="footer">
		<div class="container">
			&copy; 2015 Think Before You Launch
		</div>
	</div>
	<div class="overlay"></div>
	<script>
		$(document).ready(function(){

			$('#navigation-button').click(function(){
				$('#navigation').toggleClass('active');
			})
		});
	</script>