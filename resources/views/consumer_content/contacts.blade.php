<div class="tp-breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <ol class="breadcrumb">
          <li><a href="#"><?php echo trans('web.home');?></a></li>
          <li class="active"><?php echo trans('web.contact');?></li>
        </ol>
      </div>
    </div>
  </div>
</div>
<div class="main-container">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <p><?php echo trans('web.contact');?></p>
      </div>
      <div class="col-md-6">
        <div class="well-box">
          <form >

            <!-- Text input-->
            <div class="form-group">
              <label class="control-label" for="first"><?php echo trans('web.name');?> <span class="required">*</span></label>
              <input id="first" name="first" type="text" placeholder="<?php echo trans('web.name');?>" class="form-control input-md" required>
            </div>
            <!-- Text input-->
            <div class="form-group">
              <label class=" control-label" for="email"><?php echo trans('web.email');?> <span class="required">*</span></label>
              <input id="email" name="email" type="text" placeholder="<?php echo trans('web.email');?>" class="form-control input-md" required>
            </div>
            <div class="form-group">
              <label class=" control-label" for="email"><?php echo trans('web.address');?> <span class="required">*</span></label>
              <input id="email" name="email" type="text" placeholder="<?php echo trans('web.address');?>" class="form-control input-md" required>
            </div>

            <!-- Text input-->
            <div class="form-group">
              <label class=" control-label" for="phone"><?php echo trans('web.phone');?> <span class="required">*</span></label>
              <input id="phone" name="phone" type="text" placeholder="<?php echo trans('web.phone');?>" class="form-control input-md" required>
            </div>
            <!-- Textarea -->
            <div class="form-group">
              <label class="  control-label" for="message"><?php echo trans('web.message');?></label>
              <textarea class="form-control" rows="6" id="message" name="message"><?php echo trans('web.message');?></textarea>
            </div>

            <!-- Button -->
            <div class="form-group">
              <button id="submit" name="submit" class="btn tp-btn-default tp-btn-lg"><?php echo trans('web.contactSubmit');?></button>
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-6 contact-info">
        <div class="well-box">
          <ul class="listnone">
            <li class="address">
              <h2 style="color:#2798c6"><i class="fa fa-map-marker"></i><?php echo trans('web.contactLocation');?></h2>
              <p>Henry Fordin katu 6A, 00150 Helsinki</p>
            </li>
            <li class="email">
              <h2 style="color:#2798c6"><i class="fa fa-envelope"></i><?php echo trans('web.email');?></h2>
              <p>Info@fitcard.fi</p>
            </li>
            <li class="call">
              <h2 style="color:#2798c6"><i class="fa fa-phone"></i><?php echo trans('web.contactPhone');?></h2>
              <p>045 146 3755</p>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
