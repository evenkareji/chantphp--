<?php
    session_start();

  $dsn='mysql:dbname=my_chat;host=localhost;charset=utf8';
        $user='root';
        $password=1234;
        $dbh=new PDO($dsn,$user,$password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
?>
        <!DOCTYPE html>
        <html lang="ja">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <link rel="stylesheet" href="style.css">
            <title>Document</title>
        </head>
        <body>
            <?php
            print $_SESSION['user_name'].' ログイン中'.'<br><br><br>';

          try{

              $ps=$dbh->query('SELECT *FROM posts ORDER BY id DESC');
              while($r=$ps->fetch()){
                  if(strpos($r['image'],'.jpeg')!==false){

                      $tg=$r['image'];
                      $tb=$r['id'];
                      $ii=null;
                      $ps_ii=$dbh->query("SELECT DISTINCT*FROM good WHERE id=$tb");

                      $count_iine=0;
                      while($r_ii=$ps_ii->fetch()){
                          $ii=$ii." ". $r_ii['nam'];
                          $count_iine++;
                      }

                      $_SESSION['message']=$r['message'];
                      print "<id='box'>{$r['id']}【投稿者:名無しさん】{$r['modified']}
                      <p class='iine'><a href=iine.php?tran_b=$tb>いいね!</a>
                      ($count_iine):$ii" . "</p><br>" . nl2br($r['message']) . "<br><a href='./chat_img/$tg' TARGET='_blank'>
                      <img src='./chat_img/$tg'></a><br>
                      <p class='com'><a href='com.php?sn=$tb'>
                      コメントする時はここをクリック</a></p>";
                      $ps_com=$dbh->query("SELECT *FROM comment WHERE id=$tb");
                      $coun=1;
                      while($r_com=$ps_com->fetch()){
                          print "<p class='com'>投稿コメント{$coun}<br>
                          【{$r_com['nam']}さんのメッセージ】{$r['modified']}<br>"
                          . nl2br($r_com['com']) . "</p>";
                          $coun++;
                      }
                      print "</p></div>";
                      // 新しく文字を打ち込めるにする必要性はないsqlのデータをいじるだけでいい
                  print
                        "<div class='come'>
                       <small><a href='chat_edit.php?code=$tb'>投稿修正</a><br>
                      <a href='chat_delete.php?code=$tb'>投稿削除</a></small><br>
                      <div>";


                  }
                  else{
                      // $r=$ps->fetch();があったからひとつ前の投稿にバグが生じた
                  $tb=$r['id'];
                   $ps_ii=$dbh->query("SELECT DISTINCT*FROM good WHERE id=$tb");

                    print "{$r['id']}【投稿者:名無しさん】{$r['modified']}";
                      print '<br>';
                      print $r['message'];
                      print '<br>';
                       print
                        "<div class='come'>
                       <small><a href='chat_edit.php?code=$tb'>投稿修正</a><br>
                      <a href='chat_delete.php?code=$tb'>投稿削除</a></small><br>
                      <div>";


                  }

              }

              print "</div><div id='hidari'><br><br><br>
              <a href='chat_submit.php'>メッセージを送る</a>
              <p> <a href='../login/logout.php'>ログアウト</a></p></div>";
              $dbh=null;
          }
          catch(Exception $e){
               print 'こん';
             echo $e->getMessage();
              print 'ただいま障害により大変ご迷惑をお掛けしております。';
              exit();
          }
                  ?>
        </body>
        </html>
