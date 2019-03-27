<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>主页</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    session_start();
    error_reporting(E_ERROR);
    include_once("./dependencies.php");
    //命令列表：D为按字符串删除，A为增加，S为随机选择，L为列出，C为清空。
    $o_msg = "";
    if ($_POST['s_name'] != null) {
        $in_name = $_POST['s_name'];
    } else {
        $in_name = "";
    }

    if ($_SESSION['p_list'] == null) {
        $_SESSION['p_list'] = new \Ds\Vector();
    }
    $p_data = $_SESSION['p_list'];
    if ($_POST['s_op'] == 'D') {
        $o_msg = "删除：";
        $deletesucc = false;
        foreach ($p_data as $key => $p_v) {
            if ($p_v == $in_name) {
                $p_data->remove($key);
                $o_msg .= $p_v;
                $o_msg .= ", ";
                $deletesucc = true;
            }
        }
        if (!$deletesucc) {
            $o_msg = "项目不存在，无法删除。";
        }
    } else if ($_POST['s_op'] == 'A') {
        if ($_POST['s_name'] != "") {
            $dupicatecheck = false;
            foreach ($p_data as $key => $p_v) {
                if ($p_v == $in_name) {
                    $dupicatecheck = true;
                }
            }
            if (!$dupicatecheck) {
                $p_data->push($in_name);
                $o_msg = "添加：" . $in_name;
            } else {
                $o_msg = "项目已存在。";
            }
        }
    } else if ($_POST['s_op'] == 'S') {
        if (count($p_data) > 0) {
            $randint = random_int(0, count($p_data) - 1);
            //echo count($p_data)."<br>";
            //echo $randint;
            $o_msg = "选择了：" . $p_data->get($randint);
        } else {
            $o_msg = "班级内无人。";
            $_POST['s_op'] = 'A';
        }
    } else if ($_POST['s_op'] == 'L') {
        $o_msg = "所有项目：";
        foreach ($p_data as $key => $p_v) {
            $o_msg .= $p_v . ', ';
        }
    } else if ($_POST['s_op'] == 'C') {
        $p_data->clear();
        $o_msg = "清空完毕！";
    } else {
        if ($_POST['s_op'] != "") $o_msg = "以下指令不存在：" . $_POST['s_op'];
    }
    $_SESSION['p_list'] = $p_data;
    ?>
</head>

<body>
    <div id="container" style="width: 80%; margin: 0 auto;">

        <form action="main.php" method="post">
            <p class="teal card-panel white-text">点名系统 v0.0.0.1 @ Teamer Club</p>
            <div class="row">
                <div class="col s8">
                    <div class="col s12 input-field">
                        <input type="text" name="s_name" id="s_name" class="white teal-text-text center-align z-depth-1 validate">
                        <label for="s_name">名称</label>
                    </div>
                    <div class="row">
                        <p class="teal-text col">命令</p>
                        <!--<input type="text" name="s_op" id="s_op" class="input-field white teal-text center-align z-depth-1" value="A">-->
                        <p class="col">
                            <label>
                                <input name="s_op" type="radio" id="A" value="A" class="with-gap col" <?php if ($_POST['s_op'] == 'A' || $_POST['s_op'] == null) {
                                                                                                            echo "checked";
                                                                                                        } ?> />
                                <span>添加</span>
                            </label>
                        </p>
                        <p class="col">
                            <label>
                                <input name="s_op" type="radio" id="S" value="S" class="with-gap col" <?php if ($_POST['s_op'] == 'S') {
                                                                                                            echo "checked";
                                                                                                        } ?> />
                                <span>随机</span>
                            </label>
                        </p>
                        <p class="col">
                            <label>
                                <input name="s_op" type="radio" id="L" value="L" class="with-gap col" <?php if ($_POST['s_op'] == 'L') {
                                                                                                            echo "checked";
                                                                                                        } ?> />
                                <span>列出</span>
                            </label>
                        </p>
                        <p class="col">
                            <label>
                                <input name="s_op" type="radio" id="D" value="D" class="with-gap col" <?php if ($_POST['s_op'] == 'D') {
                                                                                                            echo "checked";
                                                                                                        } ?> />
                                <span>删除</span>
                            </label>
                        </p>
                        <p class="col">
                            <label>
                                <input name="s_op" type="radio" id="C" value="C" class="with-gap col" />
                                <span>清空</span>
                            </label>
                        </p>
                    </div>
                    <p class="teal-text"><?php echo $o_msg; ?></p>
                </div>
                <div class="col s4">
                    <button class="btn col s2 waves-effect waves-light" type="submit" name="action">提交
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </div>



        </form>

    </div>
</body>


</html>