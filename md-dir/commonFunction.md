# 在SpeedPHP使用中封装的公共方法 #

----------


| 方法名 | 参数值 | 返回值type | 功能 |
| :-: | :-: | :-: | :-: |
| keepField | $arr $str | arr | 保留数组中的字段 |
| setEmptyStr | $arr $str | arr | 设置数组里为空字符的值 |
| dirCreate | $dir | null | 目录生成(默认为setFerre) |
| checkUpdateArr1 | $old_arr $new_arr | arr | 新数组的更新 |
| emptyNotice | $data $notice_str | null | 数组和字符串的错误提示封装 |
| emptyArrNotice | $arr_data $notice_str | null | 数组类的错误提示封装(提示字符为以逗号隔开的字符串) |
| abandonField | $arr $str | arr | 舍弃数组中的字符串，$str逗号隔开 |
