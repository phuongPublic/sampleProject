<?php if ($this->Common->getDeviceType() == 1) : ?>
    <?php echo $this->element($this->Common->getIsp() . '/page_error'); ?>
<?php elseif ($this->Common->getDeviceType() == 2) : ?>
    <?php echo $this->element($this->Common->getIsp() . '/iphone_page_error'); ?>
<?php elseif ($this->Common->getDeviceType() == 3) : ?>
    <?php echo $this->element($this->Common->getIsp() . '/android_page_error'); ?>
<?php endif; ?>