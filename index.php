<?php

ini_set('session.cookie_httponly', true);
session_start();
header("Content-Security-Policy: script-src 'self'");

if (empty($_SESSION['comments'])) {
  $_SESSION['comments'] = [];
}

if (!empty($_POST['comment'])) {
  $_POST['comment'] = Comment::clearContent($_POST['comment']);
  $_SESSION['comments'][] = Comment::addComment($_POST['comment']);
}

class Comment {
  public static function addComment($comment) {
    return [
      'comment' => $comment,
      'created_at' => date('d/m/Y H:i:s')
    ];
  }

  public static function clearContent($comment) {
    $comment = htmlspecialchars($comment);
    $comment = htmlentities($comment);
    $comment = strip_tags($comment);

    return $comment;
  }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Comentários</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <main id="comments">
    <header>
      <h1>Comentários</h1>
      <p>Comente abaixo o que desejar!</p>
    </header>

    <form action="index.php" method="POST">
      <div>
        <label>Comentário</label>
        <textarea rows="8" name="comment"></textarea>
      </div>

      <input type="submit" value="Enviar" />
    </form>

    <footer>
      <h1>Outros comentários</h1>

      <table>
        <?php foreach ($_SESSION['comments'] as $comment): ?>
          <tr class="comment">
            <td>
              <h4><?= $comment['created_at'] ?></h4>
              <p><?= $comment['comment'] ?></p>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </footer>
  </main>
</body>
</html>