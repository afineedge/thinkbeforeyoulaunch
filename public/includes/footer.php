
	<div id="contact">
		<div class="container">
			<div class="col-xs-24 col-sm-10">
				<h3><?php echo htmlencode($homepage_contentRecord['contact_headline']) ?></h3>
				<?php echo $homepage_contentRecord['contact_copy']; ?>
				<form>
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" name="name" placeholder="Your Name">
					</div>
					<div class="form-group">
						<label for="name">Email Address</label>
						<input type="email" class="form-control" name="email" placeholder="Your Email Address">
					</div>
					<div class="form-group">
						<label for="name">Comments/Questions</label>
						<textarea class="form-control" name="comments" placeholder="Your Comments/Questions"></textarea>
					</div>
					<button type="submit" class="btn btn-default">Submit</button>
				</form>
				<hr class="visible-xs" />
			</div>
			<div class="col-xs-24 col-sm-14">
				<h3><?php echo htmlencode($homepage_contentRecord['newsletter_headline']) ?></h3>
				<?php echo $homepage_contentRecord['newsletter_copy']; ?>
				<a href="<?php echo htmlencode($homepage_contentRecord['newsletter_link_url']) ?>"><?php echo htmlencode($homepage_contentRecord['newsletter_link_copy']) ?> &gt;</a>
				<hr />
				<h3><?php echo htmlencode($homepage_contentRecord['learn_more_headline']) ?></h3>
				<?php echo $homepage_contentRecord['learn_more_copy']; ?>
				<a href="<?php echo htmlencode($homepage_contentRecord['learn_more_link_url']) ?>"><?php echo htmlencode($homepage_contentRecord['learn_more_link_copy']) ?> &gt;</a>
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