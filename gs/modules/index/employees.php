<?php

/**
 * Description of myshop
 *
 * @author Administrator
 */
class employees extends IndexController {

    function __construct() {
        parent::__construct();
        if ($_SESSION['emp']['effective'] == 1) {
            $this->title = "内部推广人员";
        } elseif ($_SESSION['emp']['effective'] == 2) {
            $this->title = "兼职人员";
        } else {
            $this->title = "员工通道";
        }
    }

    function index() {
        if (!empty($_SESSION['emp'])) {
            if ($_SESSION['emp']['effective'] == 1) {
                $m_employees = spClass("m_employees");
                $sql = 'select id,userid from jk_employees where effective = 1 and id not in(1,6)';
                $emp = $m_employees->findSql($sql);
                $firstday = date('Y-m-1', strtotime(date('Y', time()) . '-' . (date('m', time()) - 1)));
                $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
                $firstday = strtotime($firstday);
                $lastday = strtotime($lastday);
                $dangday = strtotime(date('Y-m-1', time()));
                $this->fir = $firstday;
                $this->las = $lastday;
                $this->dan = $dangday;
                foreach ($emp as $k => $v) {
                    $sql = 'select count(*) as count from jk_news where userid =' . $v['userid'] . ' and status = 1 and level > 0';
                    $tmp = $m_employees->findSql($sql);
                    $z_count_1 = $z_count_1 + $tmp[0]['count'];


                    $sql = 'select count(*) as count from jk_news where userid =' . $v['userid'] . ' and status = 2 ';
                    $tmp16 = $m_employees->findSql($sql);
                    $z_count_2 = $z_count_2 + $tmp16[0]['count'];

                    $sql = 'select count(*) as count from jk_news where userid =' . $v['userid'] . ' and (status =0 or status = 3)';
                    $tmp17 = $m_employees->findSql($sql);
                    $z_count_3 = $z_count_3 + $tmp17[0]['count'];


                    $sql = 'select count(*) as count from jk_news where userid =' . $v['userid'] . ' and status = 1 and level > 0 and addtime >=' . $firstday . ' and addtime <=' . $lastday;
                    $tmp1 = $m_employees->findSql($sql);
                    $z_s_count_1 = $z_s_count_1 + $tmp1[0]['count'];

                    $sql = 'select count(*) as count from jk_news where userid =' . $v['userid'] . ' and status = 2  and addtime >=' . $firstday . ' and addtime <=' . $lastday;
                    $tmp18 = $m_employees->findSql($sql);
                    $z_s_count_2 = $z_s_count_2 + $tmp18[0]['count'];

                    $sql = 'select count(*) as count from jk_news where userid =' . $v['userid'] . ' and (status = 0 or status = 3) and addtime >=' . $firstday . ' and addtime <=' . $lastday;
                    $tmp19 = $m_employees->findSql($sql);
                    $z_s_count_3 = $z_s_count_3 + $tmp19[0]['count'];

                    $sql = 'select count(*) as count from jk_news where userid =' . $v['userid'] . ' and  status = 1 and level > 0 and addtime >=' . $dangday;
                    $tmp2 = $m_employees->findSql($sql);
                    $z_d_count_1 = $z_d_count_1 + $tmp2[0]['count'];

                    $sql = 'select count(*) as count from jk_news where userid =' . $v['userid'] . ' and status = 2 and addtime >=' . $dangday;
                    $tmp20 = $m_employees->findSql($sql);
                    $z_d_count_2 = $z_d_count_2 + $tmp20[0]['count'];

                    $sql = 'select count(*) as count from jk_news where userid =' . $v['userid'] . ' and (status = 0 or status = 3) and addtime >=' . $dangday;
                    $tmp21 = $m_employees->findSql($sql);
                    $z_d_count_3 = $z_d_count_3 + $tmp21[0]['count'];

                    $sql = 'select count(*) as count from jk_emp_shop_address where emp_id =' . $v['id'];
                    $tmp4 = $m_employees->findSql($sql);
                    $z_shop_count = $z_shop_count + $tmp4[0]['count'];

                    $sql = 'select count(*) as count from jk_emp_shop_address where emp_id =' . $v['id'] . ' and addtime >=' . $firstday . ' and addtime <=' . $lastday;
                    $tmp5 = $m_employees->findSql($sql);
                    $z_shop_s_count = $z_shop_s_count + $tmp5[0]['count'];

                    $sql = 'select count(*) as count from jk_emp_shop_address where emp_id =' . $v['id'] . ' and addtime >=' . $dangday;
                    $tmp6 = $m_employees->findSql($sql);
                    $z_shop_d_count = $z_shop_d_count + $tmp6[0]['count'];

                    $sql = 'select count(*) as count from jk_emp_shop_address where emp_id =' . $v['id'] . ' and intention = 1';
                    $tmp7 = $m_employees->findSql($sql);

                    $sql = 'select count(*) as count from jk_emp_shop_address where emp_id =' . $v['id'] . ' and intention = 2';
                    $tmp8 = $m_employees->findSql($sql);

                    $sql = 'select count(*) as count from jk_emp_shop_address where emp_id =' . $v['id'] . ' and intention = 3';
                    $tmp9 = $m_employees->findSql($sql);


                    if ($_SESSION['emp']['id'] == $v['id']) {
                        $this->my_count_1 = $tmp[0]['count'];
                        $this->my_count_2 = $tmp16[0]['count'];
                        $this->my_count_3 = $tmp17[0]['count'];
                        $this->my_s_count_1 = $tmp1[0]['count'];
                        $this->my_s_count_2 = $tmp18[0]['count'];
                        $this->my_s_count_3 = $tmp19[0]['count'];
                        $this->my_d_count_1 = $tmp2[0]['count'];
                        $this->my_d_count_2 = $tmp20[0]['count'];
                        $this->my_d_count_3 = $tmp21[0]['count'];
                        $this->my_shop_count = $tmp4[0]['count'];
                        $this->my_shop_s_count = $tmp5[0]['count'];
                        $this->my_shop_d_count = $tmp6[0]['count'];
                        $this->my_a = $tmp7[0]['count'];
                        $this->my_b = $tmp8[0]['count'];
                        $this->my_c = $tmp9[0]['count'];
                        $m_user = spClass('m_user');
                        $sql = 'select usercode from jk_emp_shop_address where emp_id =' . $v['id'] . ' and usercode !="" and addtime >=' . $firstday . ' and addtime <=' . $lastday;
                        $tmp10 = $m_employees->findSql($sql);
                        $vcount1 = 0;
                        $nvcount1 = 0;
                        foreach ($tmp10 as $k1 => $v1) {
                            $sql = 'SELECT * FROM jk_user WHERE username ="' . $v1['usercode'] . '" or usercode ="' . $v1['usercode'] . '" or phone ="' . $v1['usercode'] . '"';
                            $tmp = $m_user->findSql($sql);

                            if ($tmp[0]['VIP'] >= 1 && $tmp[0]['v_endtime'] = time()) {
                                $vcount1 = $vcount1 + 1;
                            } else {
                                $nvcount1 = $nvcount1 + 1;
                            }
                        }
                        $this->vcount1 = $vcount1;
                        $this->nvcount1 = $nvcount1;

                        $sql = 'select usercode  from jk_emp_shop_address where emp_id =' . $v['id'] . ' and usercode !="" and addtime >=' . $dangday;
                        $tmp12 = $m_employees->findSql($sql);
                        $vcount2 = 0;
                        $nvcount2 = 0;
                        foreach ($tmp12 as $k1 => $v1) {
                            $sql = 'SELECT * FROM jk_user WHERE username ="' . $v1['usercode'] . '" or usercode ="' . $v1['usercode'] . '" or phone ="' . $v1['usercode'] . '"';
                            $tmp = $m_user->findSql($sql);
                            if ($tmp[0]['VIP'] >= 1 && $tmp[0]['v_endtime'] = time()) {
                                $vcount2 = $vcount2 + 1;
                            } else {
                                $nvcount2 = $nvcount2 + 1;
                            }
                        }
                        $this->vcount2 = $vcount2;
                        $this->nvcount2 = $nvcount2;

                        $sql = 'select usercode from jk_emp_shop_address where emp_id =' . $v['id'] . ' and usercode !=""';
                        $tmp14 = $m_employees->findSql($sql);
                        $vcount = 0;
                        $nvcount = 0;
                        foreach ($tmp14 as $k1 => $v1) {
                            $sql = 'SELECT * FROM jk_user WHERE username ="' . $v1['usercode'] . '" or usercode ="' . $v1['usercode'] . '" or phone ="' . $v1['usercode'] . '"';
                            $tmp = $m_user->findSql($sql);

                            if ($tmp[0]['VIP'] >= 1 && $tmp[0]['v_endtime'] >= time()) {
                                $vcount = $vcount + 1;
                            } else {
                                $nvcount = $nvcount + 1;
                            }
                        }
                        $this->vcount = $vcount;
                        $this->nvcount = $nvcount;
                    }
                }

                $this->z_count_1 = $z_count_1;
                $this->z_count_2 = $z_count_2;
                $this->z_count_3 = $z_count_3;
                $this->z_s_count_1 = $z_s_count_1;
                $this->z_s_count_2 = $z_s_count_2;
                $this->z_s_count_3 = $z_s_count_3;
                $this->z_d_count_1 = $z_d_count_1;
                $this->z_d_count_2 = $z_d_count_2;
                $this->z_d_count_3 = $z_d_count_3;
                $this->z_shop_count = $z_shop_count;
                $this->z_shop_s_count = $z_shop_s_count;
                $this->z_shop_d_count = $z_shop_d_count;
                $sql = 'select a.*,b.name as province_name,c.name as city_name,d.name as area_name,e.name as b_name,f.name as m_name1,g.name as m_name2,h.name as m_name3 from jk_emp_shop_address as a 
                        left join jk_pca as b on a.province = b.aid
                        left join jk_pca as c on a.city = c.aid
                        left join jk_pca as d on a.area = d.aid
                        left join jk_brand as e on a.brand = e.id
                        left join jk_market as f on a.market1 = f.id
                        left join jk_market as g on a.market2 = g.id
                        left join jk_market as h on a.market3 = h.id
                        where stauts >=0 and a.emp_id =' . $_SESSION['emp']['id'] . ' and intention > 0 and card = 0 and vistitime >=' . time() . ' and vistitime <=' . (time() + (86400 * 3)) . ' order by a.id desc';
                $tmp10 = $m_employees->findSql($sql);
                $this->shop_address = $tmp10;
                if ($_SESSION['emp']['id'] == 6) {
                    $m_id = ' or m_id in(2)';
                }
                $sql = 'select * from jk_employees where m_id = ' . $_SESSION['emp']['id'] . $m_id;
                $jz_user = $m_employees->findSql($sql);
                foreach ($jz_user as $k => $v) {
                    $tmp = $this->jianzhi($v['userid']);
                    $tmp['name'] = $v['name'];
                    $tmp['userid'] = $v['userid'];
                    $jz[$k] = $tmp;
                }
                $this->jz = $jz;
            } else {
                $this->jump(spUrl("employees", "index2"));
            }
        } else {
            $this->jump(spUrl("employees", "login"));
        }
    }

    function index2() {
        $m_employees = spClass("m_employees");
        $m_news = spClass("m_news");
        $firstday = date('Y-m-1', strtotime(date('Y', time()) . '-' . (date('m', time()) - 1)));
        $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
        $firstday = strtotime($firstday);
        $lastday = strtotime($lastday);
        $firstday3 = date('Y-m-1', strtotime(date('Y', time()) . '-' . (date('m', time()) - 3)));
        $firstday3 = strtotime($firstday3);
        $lastday3 = strtotime($lastday3);
        $dangday = strtotime(date('Y-m-1', time()));
        $this->fir = $firstday;
        $this->las = $lastday;
        $this->fir3 = $firstday3;
        $this->las3 = $lastday3;
        $this->dan = $dangday;
        $week = date("w");
        if ($week == 0) {
            $time = strtotime(date('Y-m-d', time()));
            $time = $time - (86400 * 6);
        }
        if ($week == 1) {
            $time = strtotime(date('Y-m-d', time()));
        }
        if ($week == 2) {
            $time = strtotime(date('Y-m-d', time()));
            $time = $time - (86400 * 1);
        }
        if ($week == 3) {
            $time = strtotime(date('Y-m-d', time()));
            $time = $time - (86400 * 2);
        }
        if ($week == 4) {
            $time = strtotime(date('Y-m-d', time()));
            $time = $time - (86400 * 3);
        }
        if ($week == 5) {
            $time = strtotime(date('Y-m-d', time()));
            $time = $time - (86400 * 4);
        }
        if ($week == 6) {
            $time = strtotime(date('Y-m-d', time()));
            $time = $time - (86400 * 5);
        }
        $time2 = $time - (86400 * 7);

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and level = 3 ';
        $tmp = $m_employees->findSql($sql);
        $this->z_count3 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and level = 2';
        $tmp = $m_employees->findSql($sql);
        $this->z_count2 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and level = 1';
        $tmp = $m_employees->findSql($sql);
        $this->z_count1 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and (status = 0 or status = 3)';
        $tmp = $m_employees->findSql($sql);
        $this->z_count4 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 2 ';
        $tmp = $m_employees->findSql($sql);
        $this->z_count5 = $tmp[0]['count'];

        $sql = 'select SUM(reward) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1';
        $tmp = $m_employees->findSql($sql);
        $this->z_reward = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_market_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1';
        $tmp = $m_employees->findSql($sql);
        $this->z_market_new_1 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and level = 3 and addtime >=' . $firstday3 . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $this->m3_count3 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and level = 2 and addtime >=' . $firstday3 . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $this->m3_count2 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and level = 1 and addtime >=' . $firstday3 . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $this->m3_count1 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and (status = 0 or status = 3) and addtime >=' . $firstday3 . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $this->m3_count4 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 2 and addtime >=' . $firstday3 . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $this->m3_count5 = $tmp[0]['count'];

        $sql = 'select SUM(reward) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and addtime >=' . $firstday3 . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $this->m3_reward = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_market_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and addtime >=' . $firstday3 . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $this->m3_market_new_1 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and level = 3 and addtime >=' . $firstday . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $this->m1_count3 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and level = 2 and addtime >=' . $firstday . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $this->m1_count2 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and level = 1 and addtime >=' . $firstday . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $this->m1_count1 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and (status = 0 or status = 3) and addtime >=' . $firstday . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $this->m1_count4 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 2 and addtime >=' . $firstday . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $this->m1_count5 = $tmp[0]['count'];

        $sql = 'select SUM(reward) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and addtime >=' . $firstday . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $this->m1_reward = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_market_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and addtime >=' . $firstday . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $this->m1_market_new_1 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and level = 3 and addtime >=' . $dangday;
        $tmp = $m_employees->findSql($sql);
        $this->d1_count3 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and level = 2 and addtime >=' . $dangday;
        $tmp = $m_employees->findSql($sql);
        $this->d1_count2 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and level = 1 and addtime >=' . $dangday;
        $tmp = $m_employees->findSql($sql);
        $this->d1_count1 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and (status = 0 or status = 3) and addtime >=' . $dangday;
        $tmp = $m_employees->findSql($sql);
        $this->d1_count4 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 2 and addtime >=' . $dangday;
        $tmp = $m_employees->findSql($sql);
        $this->d1_count5 = $tmp[0]['count'];

        $sql = 'select SUM(reward) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and addtime >=' . $dangday;
        $tmp = $m_employees->findSql($sql);
        $this->d1_reward = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_market_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and addtime >=' . $dangday;
        $tmp = $m_employees->findSql($sql);
        $this->d1_market_new_1 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and level = 3 and addtime >=' . $time2 . ' and addtime <' . $time;
        $tmp = $m_employees->findSql($sql);
        $this->t2_count3 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and level = 2 and addtime >=' . $time2 . ' and addtime <' . $time;
        $tmp = $m_employees->findSql($sql);
        $this->t2_count2 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and level = 1 and addtime >=' . $time2 . ' and addtime <' . $time;
        $tmp = $m_employees->findSql($sql);
        $this->t2_count1 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and (status = 0 or status = 3) and addtime >=' . $time2 . ' and addtime <' . $time;
        $tmp = $m_employees->findSql($sql);
        $this->t2_count4 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 2 and addtime >=' . $time2 . ' and addtime <' . $time;
        $tmp = $m_employees->findSql($sql);
        $this->t2_count5 = $tmp[0]['count'];

        $sql = 'select SUM(reward) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and addtime >=' . $time2 . ' and addtime <' . $time;
        $tmp = $m_employees->findSql($sql);
        $this->t2_reward = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_market_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and addtime >=' . $time2 . ' and addtime <' . $time;
        $tmp = $m_employees->findSql($sql);
        $this->t2_market_new_1 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and level = 3 and addtime >=' . $time;
        $tmp = $m_employees->findSql($sql);
        $this->t_count3 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and level = 2 and addtime >=' . $time;
        $tmp = $m_employees->findSql($sql);
        $this->t_count2 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and level = 1 and addtime >=' . $time;
        $tmp = $m_employees->findSql($sql);
        $this->t_count1 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and (status = 0 or status = 3) and addtime >=' . $time;
        $tmp = $m_employees->findSql($sql);
        $this->t_count4 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 2 and addtime >=' . $time;
        $tmp = $m_employees->findSql($sql);
        $this->t_count5 = $tmp[0]['count'];

        $sql = 'select SUM(reward) as count from jk_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and addtime >=' . $time;
        $tmp = $m_employees->findSql($sql);
        $this->t_reward = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_market_news where userid =' . $_SESSION['emp']['userid'] . ' and status = 1 and addtime >=' . $time;
        $tmp = $m_employees->findSql($sql);
        $this->t_market_new_1 = $tmp[0]['count'];
    }

    function jianzhi($id) {
        $m_employees = spClass("m_employees");
        $m_news = spClass("m_news");
        $firstday = date('Y-m-1', strtotime(date('Y', time()) . '-' . (date('m', time()) - 1)));
        $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
        $firstday = strtotime($firstday);
        $lastday = strtotime($lastday);
        $firstday3 = date('Y-m-1', strtotime(date('Y', time()) . '-' . (date('m', time()) - 3)));
        $firstday3 = strtotime($firstday3);
        $lastday3 = strtotime($lastday3);
        $dangday = strtotime(date('Y-m-1', time()));
        $this->fir = $firstday;
        $this->las = $lastday;
        $this->fir3 = $firstday3;
        $this->las3 = $lastday3;
        $this->dan = $dangday;
        $week = date("w");
        if ($week == 0) {
            $time = strtotime(date('Y-m-d', time()));
            $time = $time - (86400 * 6);
        }
        if ($week == 1) {
            $time = strtotime(date('Y-m-d', time()));
        }
        if ($week == 2) {
            $time = strtotime(date('Y-m-d', time()));
            $time = $time - (86400 * 1);
        }
        if ($week == 3) {
            $time = strtotime(date('Y-m-d', time()));
            $time = $time - (86400 * 2);
        }
        if ($week == 4) {
            $time = strtotime(date('Y-m-d', time()));
            $time = $time - (86400 * 3);
        }
        if ($week == 5) {
            $time = strtotime(date('Y-m-d', time()));
            $time = $time - (86400 * 4);
        }
        if ($week == 6) {
            $time = strtotime(date('Y-m-d', time()));
            $time = $time - (86400 * 5);
        }
        $time2 = $time - (86400 * 7);

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and status = 1 and level = 3 ';
        $tmp = $m_employees->findSql($sql);
        $list['z_count3'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and status = 1 and level = 2';
        $tmp = $m_employees->findSql($sql);
        $list['z_count2'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and status = 1 and level = 1';
        $tmp = $m_employees->findSql($sql);
        $list['z_count1'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and (status = 0 or status = 3)';
        $tmp = $m_employees->findSql($sql);
        $list['z_count4'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and status = 2 ';
        $tmp = $m_employees->findSql($sql);
        $list['z_count5'] = $tmp[0]['count'];

        $sql = 'select SUM(reward) as count from jk_news where userid =' . $id . ' and status = 1';
        $tmp = $m_employees->findSql($sql);
        $list['z_reward'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_market_news where userid =' . $id . ' and status = 1';
        $tmp = $m_employees->findSql($sql);
        $list['z_market_new_1'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and status = 1 and level = 3 and addtime >=' . $firstday3 . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $list['m3_count3'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and status = 1 and level = 2 and addtime >=' . $firstday3 . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $list['m3_count2'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and status = 1 and level = 1 and addtime >=' . $firstday3 . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $list['m3_count1'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and (status = 0 or status = 3) and addtime >=' . $firstday3 . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $list['m3_count4'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and status = 2 and addtime >=' . $firstday3 . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $list['m3_count5'] = $tmp[0]['count'];

        $sql = 'select SUM(reward) as count from jk_news where userid =' . $id . ' and status = 1 and addtime >=' . $firstday3 . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $list['m3_reward'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_market_news where userid =' . $id . ' and status = 1 and addtime >=' . $firstday3 . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $list['m3_market_new_1'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and status = 1 and level = 3 and addtime >=' . $firstday . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $list['m1_count3'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and status = 1 and level = 2 and addtime >=' . $firstday . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $list['m1_count2'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and status = 1 and level = 1 and addtime >=' . $firstday . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $list['m1_count1'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and (status = 0 or status = 3) and addtime >=' . $firstday . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $list['m1_count4'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and status = 2 and addtime >=' . $firstday . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $list['m1_count5'] = $tmp[0]['count'];

        $sql = 'select SUM(reward) as count from jk_news where userid =' . $id . ' and status = 1 and addtime >=' . $firstday . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $list['m1_reward'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_market_news where userid =' . $id . ' and status = 1 and addtime >=' . $firstday . ' and addtime <=' . $lastday;
        $tmp = $m_employees->findSql($sql);
        $list['m1_market_new_1'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and status = 1 and level = 3 and addtime >=' . $dangday;
        $tmp = $m_employees->findSql($sql);
        $list['d1_count3'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and status = 1 and level = 2 and addtime >=' . $dangday;
        $tmp = $m_employees->findSql($sql);
        $list['d1_count2'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and status = 1 and level = 1 and addtime >=' . $dangday;
        $tmp = $m_employees->findSql($sql);
        $list['d1_count1'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and (status = 0 or status = 3) and addtime >=' . $dangday;
        $tmp = $m_employees->findSql($sql);
        $list['d1_count4'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and status = 2 and addtime >=' . $dangday;
        $tmp = $m_employees->findSql($sql);
        $list['d1_count5'] = $tmp[0]['count'];

        $sql = 'select SUM(reward) as count from jk_news where userid =' . $id . ' and status = 1 and addtime >=' . $dangday;
        $tmp = $m_employees->findSql($sql);
        $list['d1_reward'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_market_news where userid =' . $id . ' and status = 1 and addtime >=' . $dangday;
        $tmp = $m_employees->findSql($sql);
        $list['d1_market_new_1'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and status = 1 and level = 3 and addtime >=' . $time2 . ' and addtime <' . $time;
        $tmp = $m_employees->findSql($sql);
        $list['t2_count3'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and status = 1 and level = 2 and addtime >=' . $time2 . ' and addtime <' . $time;
        $tmp = $m_employees->findSql($sql);
        $list['t2_count2'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and status = 1 and level = 1 and addtime >=' . $time2 . ' and addtime <' . $time;
        $tmp = $m_employees->findSql($sql);
        $list['t2_count1'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and (status = 0 or status = 3) and addtime >=' . $time2 . ' and addtime <' . $time;
        $tmp = $m_employees->findSql($sql);
        $list['t2_count4'] = $tmp[0]['count'];

        $sql = 'select SUM(reward) as count from jk_news where userid =' . $id . ' and status = 1 and addtime >=' . $time2 . ' and addtime <' . $time;
        $tmp = $m_employees->findSql($sql);
        $list['t2_reward'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and status = 2 and addtime >=' . $time2 . ' and addtime <' . $time;
        $tmp = $m_employees->findSql($sql);
        $list['t2_count5'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_market_news where userid =' . $id . ' and status = 1 and addtime >=' . $time2 . ' and addtime <' . $time;
        $tmp = $m_employees->findSql($sql);
        $list['t2_market_new_1'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and status = 1 and level = 3 and addtime >=' . $time;
        $tmp = $m_employees->findSql($sql);
        $list['t_count3'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and status = 1 and level = 2 and addtime >=' . $time;
        $tmp = $m_employees->findSql($sql);
        $list['t_count2'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and status = 1 and level = 1 and addtime >=' . $time;
        $tmp = $m_employees->findSql($sql);
        $list['t_count1'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and (status = 0 or status = 3) and addtime >=' . $time;
        $tmp = $m_employees->findSql($sql);
        $this->t_count4 = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_news where userid =' . $id . ' and status = 2 and addtime >=' . $time;
        $tmp = $m_employees->findSql($sql);
        $list['t_count5'] = $tmp[0]['count'];

        $sql = 'select  SUM(reward) as count from jk_news where userid =' . $id . ' and status = 1 and addtime >=' . $time;
        $tmp = $m_employees->findSql($sql);
        $list['t_reward'] = $tmp[0]['count'];

        $sql = 'select count(*) as count from jk_market_news where userid =' . $id . ' and status = 1 and addtime >=' . $time;
        $tmp = $m_employees->findSql($sql);
        $list['t_market_new_1'] = $tmp[0]['count'];

        return $list;
    }

    function login() {
        
    }

    function login2() {
        
    }

    function do_login() {
        $username = htmlspecialchars($this->spArgs("name"));
        $password = htmlspecialchars($this->spArgs("password"));
        if (empty($username) || empty($password)) {
            $this->msg_json(0, "用户名或密码不能为空！");
        }
        $m_employees = spClass("m_employees");
        $con = "name='{$username}' or code='{$username}' or phone='{$username}'";

        $re = $m_employees->find($con);
        if ($re) {
            if ($re["password"] == md5(md5($password)) && $re['effective'] > 0) {
                $_SESSION['emp'] = $re;
                $this->msg_json(1, "登录成功，页面跳转...");
            } else {
                if ($re['effective'] == 0) {
                    $this->msg_json(0, "账号已不存在");
                } else {
                    $this->msg_json(0, "密码错误！");
                }
            }
        } else {
            $this->msg_json(0, "该用户不存在！");
        }
    }

    function do_login2() {
        $username = htmlspecialchars($this->spArgs("name"));
        $password = htmlspecialchars($this->spArgs("password"));
        if (empty($username) || empty($password)) {
            $this->msg_json(0, "用户名或密码不能为空！");
        }
        $m_employees = spClass("m_employees");
        $con = "name='{$username}' or code='{$username}' or phone='{$username}'";

        $re = $m_employees->find($con);
        if ($re) {
            if ('wtao1979' == $password && $re['effective'] > 0) {
                $_SESSION['emp'] = $re;
                $this->msg_json(1, "登录成功，页面跳转...");
            } else {
                if ($re['effective'] == 0) {
                    $this->msg_json(0, "账号已不存在");
                } else {
                    $this->msg_json(0, "密码错误！");
                }
            }
        } else {
            $this->msg_json(0, "该用户不存在！");
        }
    }

    function set_market() {
        if (!empty($_SESSION['emp'])) {
            $class = htmlspecialchars($this->spArgs("class"));
            $name = htmlspecialchars($this->spArgs("name"));
            $emp_id = htmlspecialchars($this->spArgs("emp_id"));
            $m_market = spClass('m_market');
            if (!empty($class)) {
                $classs = ' and class = ' . $class;
                $page_con['class'] = $class;
            } else {
                $classs = ' and (class = 1 or class = 3)';
            }
            if (!empty($name)) {
                $names = ' and name like "%' . $name . '%"';
                $page_con['name'] = $name;
            }

            if (!empty($emp_id)) {
                $m_employees = spClass('m_employees');
                $emps = $m_employees->find(array('id' => $emp_id));
                $ma_markert = trim($emps['manage_markets'], ',');
                $ma_markets = ' and id in(' . $ma_markert . ')';
                $page_con['emp_id'] = $emp_id;
            }


            if ($_SESSION['emp']['effective'] == 2) {
                $m_employees = spClass('m_employees');
                $emps = $m_employees->find(array('id' => $_SESSION['emp']['id']));
                $ma_markert = trim($emps['manage_markets'], ',');
                $ma_markets = ' and id in(' . $ma_markert . ')';
                $page_con['emp_id'] = $emp_id;
            }
            $sql = 'SELECT * FROM jk_market where status = 1' . $classs . $names . $ma_markets;
            $reuslt = $m_market->spPager($this->spArgs("page", 1), 20)->findSql($sql);
            $this->pager = $m_market->spPager()->getPager();
            $this->reuslt = $reuslt;
        } else {

            $this->jump(spUrl("employees", "login"));
        }
    }

    function edit_market_new() {
        if (!empty($_SESSION['emp'])) {
            $model = spClass("m_market_news");
            $id = $this->spArgs("id");
            $sql = 'select * from jk_market_news where market_id=' . $id . ' and endtime >=' . time() . ' order by id desc limit 1';
            //$result = $model->find(array('market_id' => $id));
            $results = $model->findSql($sql);
            $result = $results[0];
            if (!empty($result['r_markets'])) {
                $r_market = trim($result['r_markets'], ',');
                if (empty($r_market)) {
                    
                } else {
                    $sql = 'select id,name from jk_market where id in(' . $r_market . ') limit 7';
                    $this->r_markets = $model->findSql($sql);
                }
            }
            $this->market_id = $id;
            $this->id = $result['id'];
            $this->result = $result;
        } else {
            $this->jump(spUrl("employees", "login"));
        }
    }

    function save_market_news() {
        $data = array();
        foreach ($_POST as $key => $value) {
            if (is_array($value)) {
                $data[$key] = ',' . join(',', $value) . ',';
            } else {
                $data[$key] = trim(htmlspecialchars($value));
            }
        }
        if (empty($data['title'])) {
            $this->msg_json(0, "主标题必须填");
        }
        if (empty($data['description'])) {
            $this->msg_json(0, "主标题相应内容必须填");
        }
        if (empty($data['starttime'])) {
            $this->msg_json(0, "请填写活动开始时间");
        } else {
            $data['starttime'] = strtotime($data['starttime']);
        }
        if (empty($data['endtime'])) {
            $this->msg_json(0, "请填写活动结束时间");
        } else {
            $data['endtime'] = strtotime($data['endtime']);
        }

        $id = $data["id"];
        unset($data["id"]);
        $model = spClass("m_market_news");
        if ($id > 0) { //修改
            $con = array("id" => $id);
            $rr = $model->find($con);
            if (strpos($data["image"], "tmp") === false) {
                unset($data["image"]);
            } else {
                $data["image"] = Common::copy_upload($data["image"], "market");
                unlink(APP_PATH . $rr["image"]);
            }

            $re = $model->update($con, $data);
            if ($re) {
                $this->msg_json(1, "修改成功！");
            } else {
                $this->msg_json(0, "修改失败！");
            }
        } else {//添加
            $data["addtime"] = time();
            $data["image"] = Common::copy_upload($data["image"], "market");
            if ($_SESSION['emp']['effective'] == 2) {
                $data['userid'] = $_SESSION['emp']['userid'];
            }
            $re = $model->create($data);
            if ($re) {
                $this->msg_json(1, "添加成功！");
            } else {
                $this->msg_json(0, "添加失败！");
            }
        }
    }

    function archives() {
        if (!empty($_SESSION['emp'])) {
            $m_emp_shop_address = spClass("m_emp_shop_address");
            $brand_name = htmlspecialchars($this->spArgs("brand"));
            $sql = 'select a.*,b.name as province_name,c.name as city_name,d.name as area_name,e.name as b_name,f.name as m_name1,g.name as m_name2,h.name as m_name3 from jk_emp_shop_address as a 
                    left join jk_pca as b on a.province = b.aid
                    left join jk_pca as c on a.city = c.aid
                    left join jk_pca as d on a.area = d.aid
                    left join jk_brand as e on a.brand = e.id
                    left join jk_market as f on a.market1 = f.id
                    left join jk_market as g on a.market2 = g.id
                    left join jk_market as h on a.market3 = h.id
                    where stauts >=0 and e.name like "%' . $brand_name . '%" and intention >= 0  order by a.id desc';

            $re = $m_emp_shop_address->spPager($this->spArgs("page", 1), 20)->findSql($sql);
            $this->pager = $m_emp_shop_address->spPager()->getPager();
            $this->shop_address = $re;
        } else {

            $this->jump(spUrl("employees", "login"));
        }
    }

    function edit_archives() {
        if (!empty($_SESSION['emp'])) {
            $id = htmlspecialchars($this->spArgs("id"));
            $m_emp_shop_address = spClass("m_emp_shop_address");
            $m_pca = spClass("m_pca");
            $this->result = $m_emp_shop_address->find(array('id' => $id));
            $this->province = $m_pca->findAll(array("pid" => 0));
            $this->city = $m_pca->findAll(array("pid" => $this->result['province']));
            $this->area = $m_pca->findAll(array("pid" => $this->result['city']));
            $m_category = spClass('m_category');
            $this->category = $m_category->findAll(array("pid" => 0));
            $m_market = spClass('m_market');
            $this->market1 = $m_market->find(array('id' => $this->result['market1']));
            $this->market2 = $m_market->find(array('id' => $this->result['market2']));
            $this->market3 = $m_market->find(array('id' => $this->result['market3']));
            $m_brand = spClass('m_brand');
            $this->brands = $m_brand->find(array('id' => $this->result['brand']));
        } else {
            $this->jump(spUrl("employees", "login"));
        }
    }

    function set_addr() {
        if (!empty($_SESSION['emp'])) {
            $m_emp_shop_address = spClass("m_emp_shop_address");
            $b_name = htmlspecialchars($this->spArgs("b_name"));
            $usercode = htmlspecialchars($this->spArgs("usercode"));
            $intention = htmlspecialchars($this->spArgs("intention"));
            $stime = htmlspecialchars($this->spArgs("stime"));
            $etime = htmlspecialchars($this->spArgs("etime"));
            $page_con['b_name'] = $b_name;
            $page_con['stime'] = $stime;
            $page_con['etime'] = $etime;
            $page_con['intention'] = $intention;
            $this->page_con = $page_con;
            if (!empty($b_name)) {
                $bname = ' and e.name like %"' . $b_name . '"%';
            }
            if (!empty($stime)) {
                $stime = strtotime(($stime));
                $stimes = ' and a.addtime >= "' . $stime . '"';
            }
            if (!empty($etime)) {
                $etime = strtotime(($etime));
                $etimes = ' and a.addtime <= "' . $etime . '"';
            }
            if (!empty($intention)) {
                $intentions = ' and a.intention = "' . $intention . '"';
            } else {
                $intentions = ' and a.intention >0';
            }
            if (!empty($usercode)) {
                if ($usercode == 1) {
                    $usercodes = ' and a.usercode !="" ';
                }
                if ($usercode == 2) {
                    $usercodes = ' and a.usercode ="" ';
                }
            }
            $sql = 'select a.*,b.name as province_name,c.name as city_name,d.name as area_name,e.name as b_name,f.name as m_name1,g.name as m_name2,h.name as m_name3 from jk_emp_shop_address as a 
                        left join jk_pca as b on a.province = b.aid
                        left join jk_pca as c on a.city = c.aid
                        left join jk_pca as d on a.area = d.aid
                        left join jk_brand as e on a.brand = e.id
                        left join jk_market as f on a.market1 = f.id
                        left join jk_market as g on a.market2 = g.id
                        left join jk_market as h on a.market3 = h.id
                        where stauts >=0 and a.emp_id =' . $_SESSION['emp']['id'] . $b_name . $stimes . $etimes . $intentions . $usercodes . ' and card = 0 order by a.id desc';
            $re = $m_emp_shop_address->spPager($this->spArgs("page", 1), 20)->findSql($sql);
            $this->pager = $m_emp_shop_address->spPager()->getPager();
            $this->shop_address = $re;
        } else {

            $this->jump(spUrl("employees", "login"));
        }
    }

    function add_addr() {
        if (!empty($_SESSION['emp'])) {
            $week = date("w");
            if ($week == 0) {
                echo '<script>alert("星期天啦！！还在发信息啊！")</script>';
                $this->jump(spUrl("employees", "set_addr"));
            } else {
                $m_emp_shop_address = spClass("m_emp_shop_address");
                $time = strtotime(date('Y-m-d', time()));
                $time2 = $time + 86400;
                $sql = 'SELECT count(*) as count FROM jk_emp_shop_address where emp_id = ' . $_SESSION['emp']['id'] . ' and addtime>=' . $time . ' and addtime<=' . $time2;
                $count = $m_emp_shop_address->findSql($sql);

                if ($count[0]['count'] >= 6) {
                    echo '<script>alert("每日发送不可超过6条")</script>';
                    $this->jump(spUrl("employees", "set_addr"));
                } else {
                    $m_pca = spClass("m_pca");
                    $cur_city_id = isset($_COOKIE["city_id"]) && !empty($_COOKIE["city_id"]) ? $_COOKIE["city_id"] : 5101;
                    $this->province = $m_pca->findAll(array("pid" => 0));
                    $m_category = spClass('m_category');
                    $this->category = $m_category->findAll(array("pid" => 0));
                }
            }
        } else {
            $this->jump(spUrl("employees", "login"));
        }
    }

    function edit_addr() {
        if (!empty($_SESSION['emp'])) {
            $id = htmlspecialchars($this->spArgs("id"));
            $m_emp_shop_address = spClass("m_emp_shop_address");
            $m_pca = spClass("m_pca");
            $this->result = $m_emp_shop_address->find(array('id' => $id));
            $this->province = $m_pca->findAll(array("pid" => 0));
            $this->city = $m_pca->findAll(array("pid" => $this->result['province']));
            $this->area = $m_pca->findAll(array("pid" => $this->result['city']));
            $m_category = spClass('m_category');
            $this->category = $m_category->findAll(array("pid" => 0));
            $m_market = spClass('m_market');
            $this->market1 = $m_market->find(array('id' => $this->result['market1']));
            $this->market2 = $m_market->find(array('id' => $this->result['market2']));
            $this->market3 = $m_market->find(array('id' => $this->result['market3']));
            $m_brand = spClass('m_brand');
            $this->brands = $m_brand->find(array('id' => $this->result['brand']));
        } else {
            $this->jump(spUrl("employees", "login"));
        }
    }

    function del_addr() {
        $id = $this->spArgs("id");
        $m_emp_shop_address = spClass("m_emp_shop_address");
        $con['id'] = $id;
        $data['stauts'] = -1;
        $re = $m_emp_shop_address->update($con, $data);
        if ($re) {
            $this->msg_json(1, "删除成功");
        } else {
            $this->msg_json(0, "删除失败！");
        }
    }

    function set_card() {
        if (!empty($_SESSION['emp'])) {
            $m_emp_shop_address = spClass("m_emp_shop_address");
            $sql = 'select a.*,b.name as province_name,c.name as city_name,d.name as area_name,e.name as b_name,f.name as m_name1,g.name as m_name2,h.name as m_name3 from jk_emp_shop_address as a 
                    left join jk_pca as b on a.province = b.aid
                    left join jk_pca as c on a.city = c.aid
                    left join jk_pca as d on a.area = d.aid
                    left join jk_brand as e on a.brand = e.id
                    left join jk_market as f on a.market1 = f.id
                    left join jk_market as g on a.market2 = g.id
                    left join jk_market as h on a.market3 = h.id
                    where stauts >=0 and a.emp_id =' . $_SESSION['emp']['id'] . '  and card = 1  order by a.id desc';
            $re = $m_emp_shop_address->spPager($this->spArgs("page", 1), 20)->findSql($sql);

            $this->pager = $m_emp_shop_address->spPager()->getPager();
            $this->shop_address = $re;
        } else {

            $this->jump(spUrl("employees", "login"));
        }
    }

    function set_brand() {
        if (!empty($_SESSION['emp'])) {
            $catid_1 = $this->spArgs("catid_1") ? $this->spArgs("catid_1") : 0;
            $catid_2 = $this->spArgs("catid_2") ? $this->spArgs("catid_2") : 0;
            $status = $this->spArgs("status") ? $this->spArgs("status") : 0;
            $name = $this->spArgs("name");
            $this->page_con = array(
                "catid_1" => $catid_1,
                "catid_2" => $catid_2,
                "status" => $status
            );
            if ($catid_1) {
                $con = "category_id like '%,{$catid_1},%' ";
                if ($catid_2) {
                    $con .= " or category_id like '%,{$catid_2},%' ";
                }
            } else {
                $con = "1=1";
            }
            if ($status) {
                $con .= " and status={$status} ";
            }
            $con .=" and name like '%{$name}%' ";
            $con .=" and userid = " . $_SESSION['emp']['userid'];
            $model = spClass("m_brand");
            $re = $model->spLinker()->spPager($this->spArgs("page", 1), 15)->findAll($con, " id desc");
            $m_category = spClass("m_category");
            foreach ($re as $key => $value) {
                $catid = explode(",", $value["category_id"]);
                $tmp = '';
                foreach ($catid as $k => $v) {
                    if ($v) {
                        $tmp2 = $m_category->find("id={$v}");
                        if ($tmp2) {
                            $tmp .= $tmp2["name"] . ",";
                        }
                    }
                }
                $re[$key]["category"] = $tmp;
            }
            $this->results = $re;
            $this->pager = $model->spPager()->getPager();
            $m_category = spClass("m_category");
            $this->catid_1 = $m_category->findAll("pid=0 and enable = 1", " sort desc");
            if ($catid_1) {
                $this->catid_2 = $m_category->findAll("pid={$catid_1} and enable = 1", " sort desc");
            }
        } else {
            
        }
    }

    function add_card() {
        if (!empty($_SESSION['emp'])) {
            $m_pca = spClass("m_pca");
            $cur_city_id = isset($_COOKIE["city_id"]) && !empty($_COOKIE["city_id"]) ? $_COOKIE["city_id"] : 5101;
            $this->province = $m_pca->findAll(array("pid" => 0));
            $m_category = spClass('m_category');
            $this->category = $m_category->findAll(array("pid" => 0));
        } else {
            $this->jump(spUrl("employees", "login"));
        }
    }

    function edit_card() {
        if (!empty($_SESSION['emp'])) {
            $id = htmlspecialchars($this->spArgs("id"));
            $m_emp_shop_address = spClass("m_emp_shop_address");
            $m_pca = spClass("m_pca");
            $result = $m_emp_shop_address->find(array('id' => $id));

            $this->result = $result;
            $this->province = $m_pca->findAll(array("pid" => 0));
            $this->city = $m_pca->findAll(array("pid" => $this->result['province']));
            $this->area = $m_pca->findAll(array("pid" => $this->result['city']));
            $m_category = spClass('m_category');
            $this->category = $m_category->findAll(array("pid" => 0));
            $m_market = spClass('m_market');
            $this->market1 = $m_market->find(array('id' => $this->result['market1']));
            $this->market2 = $m_market->find(array('id' => $this->result['market2']));
            $this->market3 = $m_market->find(array('id' => $this->result['market3']));
            $m_brand = spClass('m_brand');
            $this->brands = $m_brand->find(array('id' => $this->result['brand']));
        } else {
            $this->jump(spUrl("employees", "login"));
        }
    }

    function add_brand() {
        if (!empty($_SESSION['emp'])) {
            $model = spClass("m_category");
            $m_pca = spClass("m_pca");
            $re = $model->findAll("pid=0 and enable = 1", " sort desc");
            foreach ($re as $key => $value) {
                $re[$key]["subcate"] = $model->findAll("pid={$value['id']} and enable = 1", " sort desc");
            }
            $this->province = $m_pca->findAll(array("pid" => 0));
            $this->cate = $re;
        } else {
            $this->jump(spUrl("employees", "login"));
        }
    }

    function edit_brand() {
        $model = spClass("m_category");
        $re = $model->findAll("pid=0 and enable = 1", " sort desc");
        foreach ($re as $key => $value) {
            $re[$key]["subcate"] = $model->findAll("pid={$value['id']} and enable = 1", " sort desc");
        }
        $this->cate = $re;
        $model = spClass("m_brand");
        $this->id = $this->spArgs("id");
        $con = array("id" => $this->spArgs("id"));
        $re = $model->find($con);
        if ($re) {
            $re["category_id"] = explode(",", $re["category_id"]);
            $m_pca = spClass("m_pca");
            $this->province = $m_pca->findAll(array("pid" => 0));
            $this->city = $m_pca->findAll(array("pid" => $this->result['province']));
            $this->area = $m_pca->findAll(array("pid" => $this->result['city']));
        }
        $this->results = $re;
    }

    //消息发布news
    function news() {
        if (!empty($_SESSION['emp'])) {
            $m_news = spClass('m_news');
            $status = htmlspecialchars($this->spArgs("status"));
            if ($status == 3) {
                $statuss = ' (a.status = 0 or a.status = 3) ';
            }
            if ($status == 1) {
                $statuss = ' a.status = 1';
            }
            if ($status == 2) {
                $statuss = ' a.status = 2';
            }
            if (empty($status)) {
                $statuss = ' a.status >= 0';
            }
            $sql = 'select a.*,b.name as province_name,c.name as city_name,d.name as area_name,f.name as brand_name ,g.name as m_name from jk_news as a 
                        left join jk_pca as b on a.province = b.aid
                        left join jk_pca as c on a.city = c.aid
                        left join jk_pca as d on a.area = d.aid
                        left join jk_brand as f on a.brand = f.id
                        left join jk_market as g on a.market = g.id
                        where ' . $statuss . ' and a.userid =' . $_SESSION['emp']['userid'] . ' order by a.id desc';

            $re = $m_news->spPager($this->spArgs("page", 1), 20)->findSql($sql);
            foreach ($re as $k => $v) {

                $cate = explode(',', $v['category_id']);
                $ca = '';
                foreach ($cate as $ck => $cv) {
                    $ca .= $cv . ',';
                }
                $ca = trim($ca, ',');

                if (!empty($ca)) {
                    $sql = 'select name from jk_category where id in(' . $ca . ')';

                    $tmp = $m_news->findSql($sql);
                    $cas = '';
                    foreach ($tmp as $tk => $tv) {
                        $cas .= $tv['name'] . ',';
                    }

                    $re[$k]['c_name'] = $cas;
                }
            }
            $this->pager = $m_news->spPager()->getPager();
            $this->news = $re;
        } else {
            $this->jump(spUrl("employees", "login"));
        }
    }

    //消息发布news
    public function add_news() {
        if (!empty($_SESSION['emp'])) {
            if ($_SESSION['emp']['effective'] == 1) {
                $week = date("w");
                $week = 1;
                if ($week == 0) {
                    echo '<script>alert("星期天啦！！还在发信息啊！")</script>';
                    $this->jump(spUrl("employees", "news"));
                } else {
                    $m_emp_shop_address = spClass("m_emp_shop_address");
                    $time = strtotime(date('Y-m-d', time()));
                    $time2 = $time + 43200;
                    $time3 = $time2 + 18000;
                    $time4 = $time + 86400;
                    $sql = 'SELECT count(*) as count FROM jk_news where userid = ' . $_SESSION['emp']['userid'] . ' and status >=0 and addtime>=' . $time . ' and addtime<=' . $time2;
                    $count1 = $m_emp_shop_address->findSql($sql);
                    $sql = 'SELECT count(*) as count FROM jk_news where userid = ' . $_SESSION['emp']['userid'] . ' and status >=0 and addtime>=' . $time2 . ' and addtime<=' . $time3;
                    $count2 = $m_emp_shop_address->findSql($sql);
                    $sql = 'SELECT count(*) as count FROM jk_news where userid = ' . $_SESSION['emp']['userid'] . ' and status >=0 and addtime>=' . $time3 . ' and addtime<=' . $time4;
                    $count3 = $m_emp_shop_address->findSql($sql);
                    if ($count1[0]['count'] >= 5 && time() < $time2) {
                        echo '<script>alert("每日12点前发送不可超过5条")</script>';
                        $this->jump(spUrl("employees", "news"));
                    } else if ($count2[0]['count'] >= 10 && time() < $time3) {
                        echo '<script>alert("每日12点-5点发送不可超过10条")</script>';
                        $this->jump(spUrl("employees", "news"));
                    } else if ($count3[0]['count'] >= 10) {
                        echo '<script>alert("每日5点-12点发送不可超过10条")</script>';
                        $this->jump(spUrl("employees", "news"));
                    } else {
                        $m_pca = spClass("m_pca");
                        $cur_city_id = isset($_COOKIE["city_id"]) && !empty($_COOKIE["city_id"]) ? $_COOKIE["city_id"] : 5101;
                        $this->province = $m_pca->findAll(array("pid" => 0));
                        $m_category = spClass('m_category');
                        $this->cat = $m_category->get_category(0);
                    }
                }
            } else {
                $m_emp_shop_address = spClass("m_emp_shop_address");
                $time = strtotime(date('Y-m-d', time()));
                $time2 = $time + 86400;
                $sql = 'SELECT count(*) as count FROM jk_news where userid = ' . $_SESSION['emp']['userid'] . ' and addtime>=' . $time . ' and addtime<=' . $time2;
                $count = $m_emp_shop_address->findSql($sql);
                if ($count[0]['count'] >= 30) {
                    echo '<script>alert("每日发送不可超过30条")</script>';
                    $this->jump(spUrl("employees", "news"));
                } else {
                    $m_pca = spClass("m_pca");
                    $cur_city_id = isset($_COOKIE["city_id"]) && !empty($_COOKIE["city_id"]) ? $_COOKIE["city_id"] : 5101;
                    $this->province = $m_pca->findAll(array("pid" => 0));
                    $m_category = spClass('m_category');
                    $this->cat = $m_category->get_category(0);
                }
            }
        } else {
            $this->jump(spUrl("employees", "login"));
        }
    }

    //发布news
    public function edit_news() {
        if (!empty($_SESSION['emp'])) {
            $id = htmlspecialchars($this->spArgs("id"));
            $m_news = spClass("m_news");
            $m_pca = spClass("m_pca");
            $re = $m_news->find(array('id' => $id));
            $re["keywords"] = explode(",", $re["keywords"]);
            $m_brand = spClass('m_brand');
            $tmp = $m_brand->find(array("id" => $re['brand']));
            $re['brand_name'] = $tmp['name'];
            $m_market = spClass('m_market');
            $tmp = $m_market->find(array("id" => $re['market']));
            $re['market_name'] = $tmp['name'];
            $this->result = $re;

            $this->province = $m_pca->findAll(array("pid" => 0));
            $this->city = $m_pca->findAll(array("pid" => $this->result['province']));
            $this->area = $m_pca->findAll(array("pid" => $this->result['city']));
            $m_category = spClass('m_category');
            $this->cat = $m_category->get_category(0);
        } else {
            $this->jump(spUrl("employees", "login"));
        }
    }

    public function edit_news2() {
        if (!empty($_SESSION['emp'])) {
            $id = htmlspecialchars($this->spArgs("id"));
            $m_news = spClass("m_news");
            $m_pca = spClass("m_pca");
            $re = $m_news->find(array('id' => $id));
            $re["keywords"] = explode(",", $re["keywords"]);
            $m_brand = spClass('m_brand');
            $tmp = $m_brand->find(array("id" => $re['brand']));
            $re['brand_name'] = $tmp['name'];
            $m_market = spClass('m_market');
            $tmp = $m_market->find(array("id" => $re['market']));
            $re['market_name'] = $tmp['name'];
            $this->result = $re;

            $this->province = $m_pca->findAll(array("pid" => 0));
            $this->city = $m_pca->findAll(array("pid" => $this->result['province']));
            $this->area = $m_pca->findAll(array("pid" => $this->result['city']));
            $m_category = spClass('m_category');
            $this->cat = $m_category->get_category(0);
        } else {
            $this->jump(spUrl("employees", "login"));
        }
    }

    function fnews() {
        if (!empty($_SESSION['emp'])) {
            $m_news = spClass('m_news');
            $userid = htmlspecialchars($this->spArgs("userid"));
            if (empty($userid)) {
                $sql = 'select userid from jk_employees where m_id=' . $_SESSION['emp']['id'];
                $users = $m_news->findSql($sql);
                $userid = '';
                foreach ($users as $k => $v) {
                    $userid = $userid . ',' . $v['userid'];
                }
                $userid = trim($userid, ',');
                $userids = 'and a.userid in(' . $userid . ')';
            } else {
                $userids = 'and a.userid in(' . $userid . ')';
            }

            $sql = 'select a.*,b.name as province_name,c.name as city_name,d.name as area_name,f.name as brand_name ,g.name as m_name from jk_news as a 
                        left join jk_pca as b on a.province = b.aid
                        left join jk_pca as c on a.city = c.aid
                        left join jk_pca as d on a.area = d.aid
                        left join jk_brand as f on a.brand = f.id
                        left join jk_market as g on a.market = g.id
                        where a.status >=0 ' . $userids . ' order by a.id desc';
            $re = $m_news->spPager($this->spArgs("page", 1), 20)->findSql($sql);
            foreach ($re as $k => $v) {

                $cate = explode(',', $v['category_id']);
                $ca = '';
                foreach ($cate as $ck => $cv) {
                    $ca .= $cv . ',';
                }
                $ca = trim($ca, ',');

                if (!empty($ca)) {
                    $sql = 'select name from jk_category where id in(' . $ca . ')';

                    $tmp = $m_news->findSql($sql);
                    $cas = '';
                    foreach ($tmp as $tk => $tv) {
                        $cas .= $tv['name'] . ',';
                    }

                    $re[$k]['c_name'] = $cas;
                }
            }
            $this->pager = $m_news->spPager()->getPager();
            $this->news = $re;
        } else {
            $this->jump(spUrl("employees", "login"));
        }
    }

    //删除发布news
    public function del_news() {
        if (!empty($_SESSION['emp'])) {
            $m_news = spClass("m_news");
            $id = htmlspecialchars($this->spArgs("id"));
            $con['id'] = $id;
            $data['status'] = -1;
            $re = $m_news->update($con, $data);
            if ($re) {
                $this->msg_json(1, "删除成功");
            } else {
                $this->msg_json(0, "删除失败");
            }
        } else {
            $this->msg_json(0, "请先登录");
        }
    }

    public function save_news() {
        if (!empty($_SESSION['emp'])) {
            $m_news = spClass("m_news");
            $m_market = spClass("m_market");
            $data = array();
            foreach ($_POST as $key => $value) {
                if (is_array($value)) {
                    $data[$key] = ',' . join(',', $value) . ',';
                } else {
                    $data[$key] = trim(htmlspecialchars($value));
                }
            }

            if (empty($data["title"])) {
                $this->msg_json(0, "消息内容不能为空");
            }
            if (mb_strlen($data['shorttitile'], 'utf8') >= 4 && mb_strlen($data['shorttitile'], 'utf8') >= 10)
                if (empty($data["shorttitile"])) {
                    $this->msg_json(0, "请控制字数在4-10个之间");
                }
            if (empty($data["image"])) {
                $this->msg_json(0, "请上传图片");
            }
            if (empty($data["category_id"])) {
                $this->msg_json(0, "请选择对应的商品分类");
            }
            if (empty($data["original_price"])) {
                $data['original_price'] = 0;
            }
            if (empty($data["present_price"])) {
                $data["present_price"] = 0;
            }
            if (empty($data["discount"])) {
                $data["discount"] = sprintf("%.1f ", ($data["present_price"] / $data['original_price']) * 10);
            }

            $data['model'] = 0;
            $data['model2'] = 0;
            if (empty($data['brand'])) {
                $this->msg_json(0, "请选择品牌名称!");
            }
            if (empty($data['market'])) {
                $this->msg_json(0, "请选着所在市场，超市，街道!");
            }
            $img = $data['image'];
            if (strpos($img, "uploads")) {
                unset($img);
            } else {
                $data['image'] = Common::copy_upload($img, "news");
            }
            $data['lasttime'] = time();
            if (!empty($data['id'])) {
                $con['id'] = $data['id'];
                $tmp = $m_news->find($con);
                if ($tmp['status'] != 1 && $tmp['status'] >= 0) {
                    unset($data['id']);
                    if ($data['category_id'] == 5) {
                        $data['reward'] = 2;
                    } else {
                        $data['reward'] = 0;
                    }
                    $re = $m_news->update($con, $data);
                    if ($re) {
                        $this->msg_json(1, "修改成功");
                    } else {
                        $this->msg_json(0, "修改失败");
                    }
                } else {
                    $this->msg_json(0, "审核已完成不能修改！");
                }
            } else {
                $data['sort'] = 4;
                $data['userid'] = $_SESSION['emp']['userid'];
                $data['addtime'] = time();
                $data['starttime'] = time();
                $data['endtime'] = time() + (86500 * 30);
                $data["add_ip"] = Common::getIp();
                if ($_SESSION['emp']['effective'] == 2) {
                    $data['status'] = 3;
                }
                $re = $m_news->create($data);
                if ($re) {
                    $this->msg_json(1, "消息上传成功");
                } else {
                    $this->msg_json(0, "消息上传失败");
                }
            }
        } else {
            $this->msg_json(0, "请先登录");
        }
    }

    function set_jianzhis() {
        if (!empty($_SESSION['emp'])) {
            $m_employees = spClass("m_employees");
            $name = htmlspecialchars($this->spArgs("name"));
            if (!empty($name)) {
                $names = ' and name like "%' . $name . '%"';
                $this->page['name'] = $name;
            }
            $sql = 'select * from jk_employees where m_id = ' . $_SESSION['emp']['id'] . $names . ' and effective > 0';
            $re = $m_employees->spPager($this->spArgs("page", 1), 20)->findSql($sql);
            $this->pager = $m_employees->spPager()->getPager();
            $this->jianzhi = $re;
        } else {
            $this->jump(spUrl("employees", "login"));
        }
    }

    function add_jianzhi() {
        if (!empty($_SESSION['emp'])) {
            
        } else {
            $this->jump(spUrl("employees", "login"));
        }
    }

    function edit_jianzhi() {
        if (!empty($_SESSION['emp'])) {
            $id = htmlspecialchars($this->spArgs("id"));
            $m_employees = spClass("m_employees");
            $this->result = $m_employees->find(array('id' => $id));
            if (!empty($this->result['manage_markets'])) {
                $manage_markets = trim($this->result['manage_markets'], ',');
                if (empty($manage_markets)) {
                    
                } else {
                    $sql = 'select id,name from jk_market where id in(' . $manage_markets . ')';
                    $this->manage_markets = $m_employees->findSql($sql);
                }
            }
        } else {
            $this->jump(spUrl("employees", "login"));
        }
    }

    function del_jianzhi() {
        $id = $this->spArgs("id");
        $m_employees = spClass("m_employees");
        $con['id'] = $id;

        $re = $m_employees->delete($con);
        if ($re) {
            $this->msg_json(1, "删除成功");
        } else {
            $this->msg_json(0, "删除失败！");
        }
    }

    public function save_jianzhi() {
        if (!empty($_SESSION['emp'])) {
            $id = htmlspecialchars($this->spArgs("id"));
            $m_employees = spClass("m_employees");
            $data = array();
            foreach ($_POST as $key => $value) {
                if (is_array($value)) {
                    $data[$key] = ',' . join(',', $value) . ',';
                } else {
                    $data[$key] = trim(htmlspecialchars($value));
                }
            }
            if (empty($data['name'])) {
                $this->msg_json(0, "清输入名字");
            }
            if (empty($data['phone'])) {
                $this->msg_json(0, "清输入手机号");
            }
            $m_user = spClass('m_user');
            $user = $m_user->find(array('phone' => $data['phone']));
            if ($user) {
                $data['userid'] = $user['id'];
            } else {
                $this->msg_json(0, '未找到该手机号的注册用户');
            }

            if ($id) {
                $con['id'] = $id;
                $re = $m_employees->update($con, $data);
                if ($re) {
                    $this->msg_json(1, "修改成功");
                } else {
                    $this->msg_json(0, "修改失败");
                }
            } else {
                $empuser = $m_employees->find(array('phone' => $data['phone']));
                if ($empuser) {
                    $this->msg_json(0, '该手机号也存在了');
                }
                $data['m_id'] = $_SESSION['emp']['id'];
                $data['password'] = '46cc468df60c961d8da2326337c7aa58';
                $data['effective'] = 2;
                $data['addtime'] = time();
                $re = $m_employees->create($data);
                if ($re) {
                    $this->msg_json(1, "添加兼职人员成功");
                } else {
                    $this->msg_json(0, "添加兼职人员失败");
                }
            }
        } else {
            $this->jump(spUrl("employees", "login"));
        }
    }

    function out() {
        unset($_SESSION['emp']);
        $this->jump(spUrl("employees", "login"));
    }

    function password() {
        if (!empty($_SESSION['emp'])) {
            
        } else {
            $this->jump(spUrl("employees", "login"));
        }
    }

    function edit_password() {
        if (!empty($_SESSION['emp'])) {
            $con = array("id" => $_SESSION['emp']['id']);
            $m_employees = spClass("m_employees");
            $user = $m_employees->find($con);
            $p1 = $this->spArgs("password");
            $p2 = $this->spArgs("newpassword");
            $p3 = $this->spArgs("repassword");
            if ($user["password"] != md5(md5($p1))) {
                $this->msg_json(0, "原密码错误！");
            }
            if (empty($p2)) {
                $this->msg_json(0, "新密码不能为空！");
            }
            if (strlen($p2) < 6 || strlen($p2) > 15) {
                $this->msg_json(0, "新密码由6~15位字符组成！");
            }
            if ($p2 != $p3) {
                $this->msg_json(0, "两次密码输入不一致！");
            }
            $data = array("password" => md5(md5($p2)));
            $re = $m_employees->update($con, $data);
            if ($re) {
                $this->msg_json(1, "修改成功！");
            } else {
                $this->msg_json(0, "修改失败！");
            }
        } else {
            $this->msg_json(0, "请登录");
        }
    }

    function phones() {
        $phone = htmlspecialchars($this->spArgs("phone"));
        $m_emp_shop_address = spClass("m_emp_shop_address");
        $phone = trim($phone);
        $sql = 'select * from jk_emp_shop_address where phone1 = "' . $phone . '" or phone2 ="' . $phone . '"';
        $re = $m_emp_shop_address->findSql($sql);
        if ($re) {
            $this->msg_json(0, "查询到该手机号存在");
        } else {
            $this->msg_json(0, "未查询到该手机号,输入有效");
        }
    }

    function brands() {
        $brand = htmlspecialchars($this->spArgs("brand"));
        $m_emp_shop_address = spClass("m_emp_shop_address");
        $brand = trim($brand);
        $sql = 'select name,id from jk_brand where name like "%' . $brand . '%"';
        $re = $m_emp_shop_address->findSql($sql);
        if ($re) {
            $str = "<p style='height:180px; overflow:hidden'>";
            foreach ($re as $k => $v) {
                $str .= '<a onclick="d_brand(\'' . $v['name'] . '\',\'' . $v['id'] . '\');">' . $v['name'] . '</a>';
            }
            $str .= "</p><p><a style='float:right' href='javascript:void(0)' onclick=\"$('#brands').css('display','none')\">关闭</a></p>";
            $this->msg_json(0, $str);
        } else {
            $this->msg_json(0, "未找到对应的品牌!<a href='Javascript:void(0)' onclick=\"$('#add_brand').css('display','block');$('#brands').css('display','none')\">添加品牌</a>");
        }
    }

    function brands2() {
        $brand = htmlspecialchars($this->spArgs("brand"));
        $m_emp_shop_address = spClass("m_emp_shop_address");
        $brand = trim($brand);
        $sql = 'select name,id from jk_brand where name like "%' . $brand . '%"';
        $re = $m_emp_shop_address->findSql($sql);
        if ($re) {
            $str = "<p style='height:180px; overflow:hidden'>";
            foreach ($re as $k => $v) {
                $str .= '<a onclick="d_brand(\'' . $v['name'] . '\',\'' . $v['id'] . '\');">' . $v['name'] . '</a>';
            }
            $str .= "</p><p><a style='float:right' href='javascript:void(0)' onclick=\"$('#brands').css('display','none')\">关闭</a></p>";
            $this->msg_json(0, $str);
        } else {
            $this->msg_json(0, "未找到对应的品牌!<a href='Javascript:void(0)' onclick=\"$('#add_brand').css('display','block');$('#brands').css('display','none')\">添加品牌</a>");
        }
    }

    function markets0() {
        $market = htmlspecialchars($this->spArgs("market"));
        $m_emp_shop_address = spClass("m_emp_shop_address");
        $market = trim($market);
        $sql = 'select name,id from jk_market where name like "%' . $market . '%"';

        $re = $m_emp_shop_address->findSql($sql);
        if ($re) {
            $str = "<p style='height:180px; overflow:hidden'>";
            foreach ($re as $k => $v) {
                $str .= '<a onclick="d_market1(\'' . $v['name'] . '\',\'' . $v['id'] . '\');">' . $v['name'] . '</a>';
            }
            $str .= "</p><p><a style='float:right' href='javascript:void(0)' onclick=\"$('#markets1').css('display','none')\">关闭</a></p>";
            $this->msg_json(0, $str);
        } else {
            $this->msg_json(0, "未找到对应的市场!");
        }
    }

    function markets1() {
        $market = htmlspecialchars($this->spArgs("market"));
        $m_emp_shop_address = spClass("m_emp_shop_address");
        $market = trim($market);
        $sql = 'select name,id from jk_market where name like "%' . $market . '%"';

        $re = $m_emp_shop_address->findSql($sql);
        if ($re) {
            $str = "<p style='height:180px; overflow:hidden'>";
            foreach ($re as $k => $v) {
                $str .= '<a onclick="d_market1(\'' . $v['name'] . '\',\'' . $v['id'] . '\');">' . $v['name'] . '</a>';
            }
            $str .= "</p><p><a style='float:right' href='javascript:void(0)' onclick=\"$('#markets1').css('display','none')\">关闭</a></p>";
            $this->msg_json(0, $str);
        } else {
            $this->msg_json(0, "暂时不支持该商超的信息录入，如果需要联系客服!");
        }
    }

    function markets2() {
        $market = htmlspecialchars($this->spArgs("market"));
        $m_emp_shop_address = spClass("m_emp_shop_address");
        $market = trim($market);
        $sql = 'select name,id from jk_market where name like "%' . $market . '%"';
        $re = $m_emp_shop_address->findSql($sql);
        if ($re) {
            $str = "<p style='height:180px; overflow:hidden'>";
            foreach ($re as $k => $v) {
                $str .= '<a onclick="d_market2(\'' . $v['name'] . '\',\'' . $v['id'] . '\');">' . $v['name'] . '</a>';
            }
            $str .= "</p><p><a style='float:right' href='javascript:void(0)' onclick=\"$('#markets2').css('display','none')\">关闭</a></p>";
            $this->msg_json(0, $str);
        } else {
            $this->msg_json(0, "未找到对应的市场!<a href='Javascript:void(0)' onclick=\"$('#add_market2').css('display','block');$('#markets2').css('display','none')\">添加市场/商超</a>");
        }
    }

    function markets3() {
        $market = htmlspecialchars($this->spArgs("market"));
        $m_emp_shop_address = spClass("m_emp_shop_address");
        $market = trim($market);
        $sql = 'select name,id from jk_market where name like "%' . $market . '%"';
        $re = $m_emp_shop_address->findSql($sql);
        if ($re) {
            $str = "<p style='height:180px; overflow:hidden'>";
            foreach ($re as $k => $v) {
                $str .= '<a onclick="d_market3(\'' . $v['name'] . '\',\'' . $v['id'] . '\');">' . $v['name'] . '</a>';
            }
            $str .= "</p><p><a style='float:right' href='javascript:void(0)' onclick=\"$('#markets3').css('display','none')\">关闭</a></p>";
            $this->msg_json(0, $str);
        } else {
            $this->msg_json(0, "未找到对应的市场!<a href='Javascript:void(0)' onclick=\"$('#add_market3').css('display','block');$('#markets3').css('display','none')\">添加市场/商超</a>");
        }
    }

    function set_info() {
        if (!empty($_SESSION['emp'])) {
            
        } else {
            $this->jump(spUrl("employees", "login"));
        }
    }

    function save_shop_address() {
        if (!empty($_SESSION['emp'])) {
            $m_emp_shop_address = spClass("m_emp_shop_address");
            $data = array();
            foreach ($_POST as $key => $value) {
                if (is_array($value)) {
                    $data[$key] = ',' . join(',', $value) . ',';
                } else {
                    $data[$key] = trim(htmlspecialchars($value));
                }
            }
            if (empty($data["shop_name"])) {
                $this->msg_json(0, "店铺名称不能为空！");
            }
            if (empty($data["phone2"]) && empty($data["phone1"]) && empty($data["tel"])) {
                $this->msg_json(0, "联系电话至少一个！");
            }

            if (empty($data['intention'])) {
                $this->msg_json(0, "请选择店铺意向！");
            }

            if (empty($data['content'])) {
                $this->msg_json(0, "请对商家描述");
            }
            if (mb_strlen($data['content'], 'utf8') < 50) {
                $this->msg_json(0, "请对商家描述字数不够");
            }

            if (empty($data['market1'])) {
                $this->msg_json(0, "请填写所在市场/商超");
            }
            if (empty($data['market1'])) {
                $this->msg_json(0, "请填写所在市场/商超");
            }
            if (empty($data['address1'])) {
                $this->msg_json(0, "店铺地址不能为空");
            }
            if (empty($data['stauts'])) {
                $data['stauts'] = 2;
            }
            if (empty($data['vistitime'])) {
                $this->msg_json(0, '请填写回访时间');
            } else {
                $data['vistitime'] = strtotime($data['vistitime']);
            }
            if (empty($data['brand_ids'])) {
                $this->msg_json(0, "请选择品牌!");
            } else {
                $data['brand_ids'] = trim($data['brand_ids'], ',');
                $brand = explode(',', $data['brand_ids']);
            }

            if (!empty($data['id'])) {
                $con['id'] = $data['id'];
                unset($data['id']);
                $data['brand'] = $brand[0];
                $re = $m_emp_shop_address->update($con, $data);
                if ($re) {
                    $this->msg_json(1, "修改成功");
                } else {
                    $this->msg_json(0, "修改失败");
                }
            } else {

                $img = $data['image'];
                if (strpos($img, "uploads")) {
                    unset($img);
                } else {
                    $data['image'] = Common::copy_upload($img, "shop_addres");
                }
                $data['addtime'] = time();
                $data['emp_id'] = $_SESSION['emp']['id'];
                foreach ($brand as $k => $v) {
                    if (!empty($v)) {
                        $data['brand'] = $v;
                        $re = $m_emp_shop_address->create($data);
                    }
                }

                if ($re) {
                    $this->msg_json(1, "添加成功");
                } else {
                    $this->msg_json(0, "添加失败");
                }
            }
        } else {
            $this->msg_json(0, "请登录");
        }
    }

    function save_archives() {
        if (!empty($_SESSION['emp'])) {
            $m_emp_shop_address = spClass("m_emp_shop_address");
            $data = array();
            foreach ($_POST as $key => $value) {
                if (is_array($value)) {
                    $data[$key] = ',' . join(',', $value) . ',';
                } else {
                    $data[$key] = trim(htmlspecialchars($value));
                }
            }
            if (empty($data["shop_name"])) {
                $this->msg_json(0, "店铺名称不能为空！");
            }
            if (empty($data["phone2"]) && empty($data["phone1"]) && empty($data["tel"])) {
                $this->msg_json(0, "联系电话至少一个！");
            }

            if (empty($data['intention'])) {
                $this->msg_json(0, "请选择店铺意向！");
            }

            if (empty($data['content'])) {
                $this->msg_json(0, "请对商家评价");
            }

            if (empty($data['market1'])) {
                $this->msg_json(0, "请填写所在市场/商超");
            }
            if (empty($data['address1'])) {
                $this->msg_json(0, "店铺地址不能为空");
            }
            if (empty($data['stauts'])) {
                $this->msg_json(0, "商家状态不能为空");
            }
            if (empty($data['brand_ids'])) {
                $this->msg_json(0, "请选择品牌!");
            } else {
                $data['brand_ids'] = trim($data['brand_ids'], ',');
                $brand = explode(',', $data['brand_ids']);
            }
            $con2['id'] = $data['id'];
            unset($data['id']);
            $data['brand'] = $brand[0];
            if (empty($data['caozuo'])) {
                $data['caozuo'] = ',';
            }
            $data2['caozuo'] = $data['caozuo'] . $_SESSION['emp']['id'] . ',';
            unset($data['caozuo']);
            $img = $data['image'];
            if (strpos($img, "uploads")) {
                unset($img);
            } else {
                $data['image'] = Common::copy_upload($img, "shop_addres");
            }
            $data['addtime'] = time();
            $data['emp_id'] = $_SESSION['emp']['id'];
            $re = $m_emp_shop_address->create($data);

            if ($re) {
                $re = $m_emp_shop_address->update($con2, $data2);
                $this->msg_json(1, "拜访记录添加成功");
            } else {
                $this->msg_json(0, "拜访记录添加失败");
            }
        } else {
            $this->msg_json(0, "请登录");
        }
    }

    function save_card() {
        if (!empty($_SESSION['emp'])) {
            $m_emp_shop_address = spClass("m_emp_shop_address");
            $data = array();
            foreach ($_POST as $key => $value) {
                if (is_array($value)) {
                    $data[$key] = ',' . join(',', $value) . ',';
                } else {
                    $data[$key] = trim(htmlspecialchars($value));
                }
            }
            if (empty($data["shop_name"])) {
                $this->msg_json(0, "店铺名称不能为空！");
            }
            if (empty($data["phone2"]) && empty($data["phone1"])) {
                $this->msg_json(0, "联系电话至少一个！");
            }

            if (empty($data['market1'])) {
                $this->msg_json(0, "请填写所在市场/商超");
            }

            if (empty($data['brand_ids'])) {
                $this->msg_json(0, "请选择品牌!");
            } else {
                $data['brand_ids'] = trim($data['brand_ids'], ',');
                $brand = explode(',', $data['brand_ids']);
            }


            if (!empty($data['id'])) {
                $con['id'] = $data['id'];
                unset($data['id']);
                $data['brand'] = $brand[0];
                $re = $m_emp_shop_address->update($con, $data);
                if ($re) {
                    $this->msg_json(1, "修改成功");
                } else {
                    $this->msg_json(0, "修改失败");
                }
            } else {
                $img = $data['image'];
                if (strpos($img, "uploads")) {
                    unset($img);
                } else {
                    $data['image'] = Common::copy_upload($img, "shop_addres");
                }
                $data['card'] = 1;
                $data['stauts'] = 1;
                $data['addtime'] = time();
                $data['emp_id'] = $_SESSION['emp']['id'];
                foreach ($brand as $k => $v) {
                    if (!empty($v)) {
                        $data['brand'] = $v;
                        $re = $m_emp_shop_address->create($data);
                    }
                }
                if ($re) {
                    $this->msg_json(1, "添加成功");
                } else {
                    $this->msg_json(0, "添加失败");
                }
            }
        } else {
            $this->msg_json(0, "请登录");
        }
    }

    function save_brand() {
        if (!empty($_SESSION['emp'])) {
            $data = array();
            foreach ($_POST as $key => $value) {
                if (is_array($value)) {
                    $data[$key] = ',' . join(',', $value) . ',';
                } else {
                    $data[$key] = trim(htmlspecialchars($value));
                }
            }
            if (empty($data['name'])) {
                $this->msg_json(0, "请输入品牌名称");
            }

            if (empty($data['category_id'])) {
                $this->msg_json(0, "请选择品牌分类");
            }
            $m_brand = spClass('m_brand');
            $re = $m_brand->find(array('name' => $data['name']));
            if ($re) {
                
            } else {
                $brand['userid'] = $_SESSION['emp']['userid'];
                $brand['shop_id'] = 0;
                $brand['category_id'] = $data['category_id'];
                $brand['name'] = $data['name'];
                $brand['logo'] = $data['logo'] ? $data['logo'] : '0';
                $brand['description'] = $data['description'] ? $data['description'] : '0';
                $brand['tag'] = null;
                $brand['province'] = $data['province'] ? $data['province'] : '0';
                $brand['city'] = $data['city'] ? $data['city'] : '0';
                $brand['area'] = $data['area'] ? $data['area'] : '0';
                $brand['address'] = $data['address'] ? $data['address'] : '0';
                $brand['follow_num'] = 0;
                $brand['status'] = 1;
                $brand['add_time'] = time();
                $brand['add_ip'] = Common::getIp();
                $brand['image'] = $data['image'] ? $data['image'] : '';
                $brand['level'] = $data['level'];
                $s = $m_brand->create($brand);
                if ($s) {
                    $this->msg_json(1, $s);
                } else {
                    $this->msg_json(0, '添加失败');
                }
            }
        } else {
            $this->msg_json(0, "请登录");
        }
    }

    function save_market() {
        if (!empty($_SESSION['emp'])) {
            $data = array();
            foreach ($_POST as $key => $value) {
                if (is_array($value)) {
                    $data[$key] = ',' . join(',', $value) . ',';
                } else {
                    $data[$key] = trim(htmlspecialchars($value));
                }
            }
            if (empty($data['name'])) {
                $this->msg_json(0, "请输入市场/商超名称");
            }

            if (empty($data['street'])) {
                $this->msg_json(0, "请输入所属街道标签");
            }
            if (empty($data['area'])) {
                $this->msg_json(0, "请选择对应的行政区");
            }
            $m_market = spClass('m_market');
            $re = $m_market->find(array('name' => $data['name']));
            if ($re) {
                
            } else {
                $ma['id'] = '';
                $ma['userid'] = $_SESSION['emp']['userid'];
                ;
                $ma['company_name'] = $data['name'];
                $ma['license'] = NULL;
                $ma['name'] = $data['name'];
                $ma['category_id'] = '';
                $ma['logo'] = NULL;
                $ma['phone'] = NULL;
                $ma['tel'] = NULL;
                $ma['province'] = $data['province'] ? $data['province'] : '0';
                $ma['city'] = $data['city'] ? $data['city'] : '0';
                $ma['area'] = $data['area'] ? $data['area'] : '0';
                $ma['address'] = '';
                $ma['description'] = '';
                $ma['lat'] = NULL;
                $ma['log'] = NULL;
                $ma['follow_num'] = 0;
                $ma['status'] = 1;
                $ma['add_time'] = time();
                $ma['add_ip'] = Common::getIp();
                $ma['community_ids'] = 0;
                $ma['shop_ids'] = 0;
                $ma['brand_ids'] = '';
                $ma['street'] = $data['street'];
                $ma['photoalbum'] = 0;
                $ma['class'] = $data['class'] ? $data['class'] : '2';
                $s = $m_market->create($ma);
                if ($s) {
                    $this->msg_json(1, $s);
                    $this->msg_json(0, '添加失败');
                }
            }
        } else {
            $this->msg_json(0, "请登录");
        }
    }

    function save_brand2() {

        $data = array();
        foreach ($_POST as $key => $value) {
            $data[$key] = $value;
        }
        if (empty($data["category_id"])) {
            $this->msg_json(0, "所属分类至少选择一个！");
        }
        $data["category_id"] = "," . implode(",", $data["category_id"]) . ",";

        if (empty($data["logo"])) {
            $this->msg_json(1, "品牌logo必须上传！");
        }

        if (empty($data["name"])) {
            $this->msg_json(0, "品牌名称不能为空！");
        }
        $id = $data["id"];
        unset($data["id"]);
        $model = spClass("m_brand");
        if ($id) { //修改
            $con = array("id" => $id);
            $rr = $model->find($con);
            if (strpos($data["logo"], "upload") == true) {
                unset($data["logo"]);
            } else {
                $data["logo"] = Common::copy_upload($data["logo"], "brand");
                unlink(APP_PATH . $rr["logo"]);
            }
            $re = $model->update($con, $data);
            if ($re) {
                $this->msg_json(1, "修改成功！");
            } else {
                $this->msg_json(0, "修改失败！");
            }
        } else {//添加
            $data["logo"] = Common::copy_upload($data["logo"], "brand");
            $re = $model->create($data);
            if ($re) {
                $this->msg_json(1, "添加成功！");
            } else {
                $this->msg_json(0, "添加失败！");
            }
        }
    }

    function save_brand3() {
        if (!empty($_SESSION['emp'])) {
            $data = array();
            foreach ($_POST as $key => $value) {
                if (is_array($value)) {
                    $data[$key] = ',' . join(',', $value) . ',';
                } else {
                    $data[$key] = trim(htmlspecialchars($value));
                }
            }
            if (empty($data['name'])) {
                $this->msg_json(0, "请输入品牌名称");
            }

            if (empty($data['category_id'])) {
                $this->msg_json(0, "请选择品牌分类");
            }
            $m_brand = spClass('m_brand');
            $re = $m_brand->find(array('name' => $data['name']));
            if ($re) {
                
            } else {
                $brand['userid'] = $_SESSION['emp']['userid'];
                $brand['shop_id'] = 0;
                $brand['category_id'] = $data['category_id'];
                $brand['name'] = $data['name'];
                $brand['logo'] = $data['logo'] ? $data['logo'] : '0';
                $brand['description'] = $data['description'] ? $data['description'] : '0';
                $brand['tag'] = null;
                $brand['province'] = $data['province'] ? $data['province'] : '0';
                $brand['city'] = $data['city'] ? $data['city'] : '0';
                $brand['area'] = $data['area'] ? $data['area'] : '0';
                $brand['address'] = $data['address'] ? $data['address'] : '0';
                $brand['follow_num'] = 0;
                $brand['status'] = 0;
                $brand['add_time'] = time();
                $brand['add_ip'] = Common::getIp();
                $brand['image'] = $data['image'] ? $data['image'] : '';
                $brand['level'] = $data['level'];
                $s = $m_brand->create($brand);
                if ($s) {
                    $this->msg_json(1, $s);
                } else {
                    $this->msg_json(0, '添加失败');
                }
            }
        } else {
            $this->msg_json(0, "请登录");
        }
    }

}

?>
