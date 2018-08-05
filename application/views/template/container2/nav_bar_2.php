<!-- - - - - - - - - - - - Header - - - - - - - - - - - - - -->
<div class="header alternate">
	<div class="top-bar">
		<div class="container">
			<div class="row">
				<div class="col-md-3 col-xs-2">
					<button data-dialog="somedialog-1" id="login-button" class="trigger"><i class="icon-user"></i><span>Sign In</span></button>
					<div id="somedialog-1" class="dialog">
						<div class="dialog__overlay"></div>
						<div class="dialog__content">
							<div class="morph-shape">
								<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 364 434" preserveAspectRatio="none">
									<rect x="2" y="2" fill="none" width="360" height="430"/>
								</svg>
							</div>
							<div class="dialog-inner">
								<button class="action" data-dialog-close><i class="icon-cancel"></i></button>
								<form method="post" action="http://cardealer.webtemplatemasters.com/" onsubmit="return thememakers_app_authentication.login()">
									<div class="form-reg">
										<i class="icon-user-7"></i>
										<h2>Sign In</h2>
										<p class="error-login">
											<strong>ERROR:</strong>
											The login/password you entered is incorrect.									
										</p>
										<p>
											<input placeholder="Username*" type="text" id="tmm_user_login" autocomplete="off"/>
										</p>
										<p>
											<input placeholder="Password*" type="password" id="tmm_user_pass" autocomplete="off"/>
										</p>
										<p>
											<a href="#" class="button dark" id="user_login_button">Login</a>
										</p>
										<p>
											<a href="../../user-login/lost-password/index.html">Forgot your password?</a>
										</p>
										<input type="submit" style="display: none;"/>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-8 col-xs-8">
					<div class="widget widget_contacts">
						<ul class="contacts-list">
							<li class="icon-warehouse">
								12 Street, Los Angeles, CA, 94101			
							</li>
							<li class="icon-phone">
								+1234 567-8901			
							</li>
						</ul>
						<!--/ .contacts-list-->
					</div>
					<!--/ .widget-->
				</div>
				<div class="col-md-1 col-xs-2">
					<div class="header-cart">
						<a href="../../shop/cart-page/index.html" class="icon-basket"></a>
						<span class="cart-products-count">0</span>
						<div class="woocommerce cart-content">
							<div class="widget woocommerce widget_shopping_cart">
								<div class="hide_cart_widget_if_empty">
									<div class="widget_shopping_cart_content"></div>
								</div>
							</div>
						</div>
					</div>
					<!-- .header-cart-->
				</div>
			</div>
		</div>
	</div>
	<div id="navHolder">
		<div class="logo-bar sticky-bar">
			<div class="container">
				<div class="row">
					<div class="col-xs-8 col-md-3">
						<div class="logo">
							<a title="Buy / Sell Car online | CarDealer WordPress Theme" href="../../index.html"><img				src="<?php echo IMAGE_SRC_URL;?>media/uploads/2014/09/logo.png" alt="Buy / Sell Car online | CarDealer WordPress Theme" /></a>
						</div>
					</div>
					<div class="col-xs-4 col-md-9">
						<!-- Responsive Navigation -->
						<label for="toggle-main-nav" class="label-toggle-main-nav">
							<div class="menu-icon-container">
								<div class="menu-icon">
									<div class="menu-global menu-top"></div>
									<div class="menu-global menu-middle"></div>
									<div class="menu-global menu-bottom"></div>
								</div>
							</div>
						</label>
						<nav id="navigation" class="navigation clearfix">
							<ul id="menu-primary-menu" class="menu">
								<li id="menu-item-107" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-has-children menu-item-107">
									<a href="<?php echo base_url(); ?>">Home</a>
								</li>
								<li id="menu-item-108" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-108 current_page_parent">
									<a href="<?php echo base_url(); ?>listings">Inventory</a>
								</li>
								<li id="menu-item-710" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-710"><a href="<?php echo base_url(); ?>about">About</a></li>
								<li id="menu-item-128" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-128"><a href="<?php echo base_url(); ?>contacts">Contacts</a></li>
							</ul>
						</nav>
						<!--/ .navigation-->
					</div>
				</div>
				<!--/ .row-->
			</div>
			<!--/ .container-->
		</div>
		<!--/ .logo-bar-->
	</div>
	<!--/ #navHolder-->
</div>
<!--/ .header-->
<!-- - - - - - - - - - - - end Header - - - - - - - - - - - - - -->