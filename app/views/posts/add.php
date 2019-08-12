<?php require APPROOT . '/views/inc/header.php' ?>

<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>

<div class="card card-body bg-light mt-5">

  <h2 class="mb-5">Add Post</h2>

  <form action="<?php echo URLROOT; ?>/posts/add" method="post">

    <div class="form-group">
      <label for="title">Title: <sup>*</sup></label>
      <input type="text" name="title" class="form-control form-control-lg <?php echo (!empty($data['title_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
      <span class="invalid-feedback"><?php echo $data['title_error'] ?></span>
    </div>

    <div class="form-group">
      <label for="body">Body: <sup>*</sup></label>
      <textarea name="body" class="form-control form-control-lg <?php echo (!empty($data['body_error'])) ? 'is-invalid' : ''; ?>"><?php echo $data['body']; ?></textarea>
      <span class="invalid-feedback"><?php echo $data['body_error'] ?></span>
    </div>

    <input type="submit" value="Submit" class="btn btn-success btn-block mt-5">
  </form>
</div>

<?php require APPROOT . '/views/inc/footer.php' ?>