<?php
$extentions = (array_key_exists("extentions", $options)) ? $options['extentions'] : [];
$src = asset('images/dummy_image.png');
if($options['value'] != null) {
    $src = $options['value'];
    if(substr( $src, 0, 4 ) != "http")
        $src = url('image/'.$src);
}
?>

<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    <div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
<?php endif; ?>

<?php if ($showLabel && $options['label'] !== false): ?>
    <?= Form::label($name, $options['label'], $options['label_attr']) ?>
<?php endif; ?>

<?php if ($showField): ?>
    <div class="row">
        <div class="col-md-4">
            <img id="{{$name}}Thumbnail" class="img-thumbnail" style="background-color: #ddd" src="{{ $src }}" alt="" />
        </div>
        <div class="col-md-8">
            <?= Form::input('file', $name, $options['value'], $options['attr']) ?>
            <?php if (sizeof($extentions) > 0): ?>
            <p class="help-block">Available Extention : <?= implode(", ", $extentions) ?></p>
            <?php endif; ?>

            <?php if ($options['help_block']['text'] && !$options['is_child']): ?>
                <<?= $options['help_block']['tag'] ?> <?= $options['help_block']['helpBlockAttrs'] ?>>
                    <?= $options['help_block']['text'] ?>
                </<?= $options['help_block']['tag'] ?>>
            <?php endif; ?>
        </div>
    </div>

<?php endif; ?>

<?php if ($showError && isset($errors)): ?>
    <?php foreach ($errors->get($nameKey) as $err): ?>
        <div <?= $options['errorAttrs'] ?>><?= $err ?></div>
    <?php endforeach; ?>
<?php endif; ?>

<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    </div>
    <?php endif; ?>
<?php endif; ?>
