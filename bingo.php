<?php
//ビンゴのカードを設定するフェーズ
    // カードの大きさを取得して数値型に修正、小数点のある数字の場合は小数点以下を切り捨てて処理を実行させる
    $bingo_size = trim(fgets(STDIN));
    $bingo_size = floor($bingo_size);
    $bingo_size = (int)$bingo_size;
    
    // 入力が数字でない場合、３以上1000未満の数字でない場合については処理を終了させる
    if($bingo_size < 3 || gettype($bingo_size)=='string' || $bingo_size > 1000){
        exit(1); 
    }

    //bingoの内容の入力とを横の列を配列に格納する処理を行う
    for($row = 1; $row <= $bingo_size; $row++){
        // 入力したビンゴの単語の配列のインデックス番号を格納する変数
        $index = $row - 1;

        //ビンゴの単語の内容を入力する
        $bingo_words[] = trim(fgets(STDIN));
        //入力したビンゴの単語の内容をbingo_rowに順番に格納する
        $bingo_row[] = explode(' ', $bingo_words[$index]);

        // 万が一ビンゴの入力が上記で定義したbingo_sizeの数よりも大きい、もしくは小さければ処理を終了させる
        if((count($bingo_row[$index]) > $bingo_size) || (count($bingo_row[$index]) < $bingo_size)){
            exit(1); 
        }
    }
    //縦の列の配列作成
    $bingo_column = [];
    //縦の配列を作成するための一時的な値を格納する配列
    $tmp_col = [];
    for($row = 1; $row <= $bingo_size; $row++){
        foreach($bingo_row as $key => $column_index){
                $index = $row - 1;
                array_push($tmp_col, $column_index[$index]);
        }
    
        $bingo_column[$index] = $tmp_col;
        $tmp_col = [];
    }
    
    //斜め列の配列作成
    $bingo_slope = [];
    for($row = 1; $row <= $bingo_size; $row++){
        $index = $row - 1;
        array_push($bingo_slope, $bingo_row[$index][$index]);
    }
    
    //逆斜め列の配列作成
    $bingo_slope_reverse = [];
    for($row = 1; $row <= $bingo_size; $row++){
        $index = $row - 1;
        $index_minas = $bingo_size - $row;
        array_push($bingo_slope_reverse, $bingo_row[$index][$index_minas]);
    }

//ビンゴを引くフェーズ
    //選ばれる単語の数を入力する 0以下の入力もしくは文字列だった場合には処理を終了する
    $number_of_input = trim(fgets(STDIN));
    $number_of_input = floor($number_of_input);
    $number_of_input = (int)$number_of_input;
    if($number_of_input <= 0 || gettype($number_of_input)=='string'){
        exit(1); 
    }

    //引く個数を縦並びで入力する
    //whileを選択した意図としては、最後の入力なので選ばれる単語の数だけ文字を入力したら勝手に処理を進めても問題ないと判断したからです
    $word = 1;
    while ($word <= $number_of_input){
    // 入力したビンゴの単語の配列のインデックス番号を格納する変数
    $index = $word - 1;

    //ビンゴの単語の内容を入力する
    $select_words[] = trim(fgets(STDIN));
    //入力したビンゴの単語の内容をbingo_rowに順番に格納する
    $word++;
    }

//ビンゴを判定するフェーズ   
    //横配列の判定
    foreach($bingo_row as $index){
       $result = array_diff($index, $select_words);
       if(empty($result)){
           echo 'yes';
            exit(1); 
       }
    }
    //縦配列の判定
    foreach($bingo_column as $index){
       $result = array_diff($index, $select_words);
       if(empty($result)){
           echo 'yes';
            exit(1); 
       }
    }
    
    //斜め配列の判定
    $result = array_diff($bingo_slope, $select_words);
    if(empty($result)){
        echo 'yes';
        exit(1); 
    }
    
    $result = array_diff($bingo_slope_reverse, $select_words);
    if(empty($result)){
        echo 'yes';
        exit(1); 
    }else{
        echo 'no';
        exit(1); 
    }


//テストの項目（この観点でテストを行なっています）
//1 ビンゴとして成り立たないカードの大きさの入力を除外できているか？（１以下の数字）
//標準入力の最初の数字を文字列、もしくは１以下の数字で入力する

//2 カードの中身を書き出す際に１列あたり、指定したカードの大きさの数だけカードの中身の入力が可能か？
//カードの大きさを入力した後に、大きさよりも大きいor小さい値を入力する

//3 ビンゴの横の配列を取得できるか？
// 60行目にvar_dump($card_array_row);挿入

//4 ビンゴの縦の配列を取得できるか？
// 60行目にvar_dump($bingo_column);挿入

//5 ビンゴの斜めの配列を取得できるか？
// 60行目にvar_dump($card_array_slope);挿入

//6 ビンゴの斜め（逆）配列を取得できるか？
// 60行目にvar_dump($card_array_slope_reverse);挿入

//7 抽選に使う値を１つの配列に格納できているか
// 60行目にvar_dump($select_words);挿入

//8 各配列でビンゴの確定ができるか？
// var_dump($result);を$result = array_diff($index, $select_words);の下の文章に格納する
//インストール方法と使い方環境php7.3.26

?>