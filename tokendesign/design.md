三、APP自用登陆型token实现步骤： 
（1）数据库用户表添加token字段和time_out这个token过期时间字段 

（2）用户登陆时（注册时自动登陆也需要）生成一个token和过期时间存入表中 

（3）在其他接口调用前，判断token是否正确，正确则继续，错误则让用户重新登陆


token：web端使用session单一判断；app端使用token（用户名+密码+id+xxxx）加密的方式单一判断；采用一种方式来识别用户登录的地方；当用户使用web登录时，不能每次都一直登录，需要判断