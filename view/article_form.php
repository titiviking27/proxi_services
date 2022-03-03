<form class="wrap" action="" method="post" enctype="multipart/form-data" novalidate>
    <label for="title">Nom d'article</label>
    <input type="text" name="title" id="title" value="<?php if (!empty($article['title'])) {
                                                            echo $article['title'];
                                                        } elseif (getInputValue('title'))
                                                        ?>">
    <span class="error"><?php spanError($errors, 'title'); ?></span>

    <label for="title">Description</label>

    <textarea id="content" name="content"><?php if (!empty($article['content'])) {
                                                echo $article['content'];
                                            } elseif (getInputValue('content'))
                                            ?></textarea>
    <span class="error"><?php spanError($errors, 'content'); ?></span>

    <label for="image">Image</label>
    <input type="file" name="image" id="image">
    <span class="error"><?php spanError($errors, 'image'); ?></span>

    <select name="status" id="status">
        <?php foreach ($lesStatus as $value) { ?>
            <option value="<?php echo $value; ?>" <?php
                                                    if (!empty($_POST['status']) && $_POST['status'] === $value) {
                                                        echo ' selected';
                                                    } elseif (!empty($article['status'])) {
                                                        if ($article['status'] === $value) {
                                                            echo ' selected';
                                                        }
                                                    }
                                                    ?>><?php echo ucfirst($value); ?></option>
        <?php } ?>
    </select>
    <input type="submit" name="submitted" value="Envoyer">
</form>