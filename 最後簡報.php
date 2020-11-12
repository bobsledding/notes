<?php
{
	['NFS'];
	_介紹 = {
		'用RPC來讓client對應到NFS各個port',
		'也可以設定固定port',
		'至少需要兩個 daemons ，一個管理用戶端是否能夠登入的問題(rpc.nfsd)， 一個管理用戶端能夠取得的權限(rpc.mountd)',
		'rpc.lockd鎖定檔案，rpc.statd檢查檔案的一致性',
		'UID,GID對應易混淆',
		'可用NIS管理使用者',
		'sync與async的差別好像很值得注意',
		'autofs'
	};
	_為何要用;
	_使用時機;
	_使用方法 = {
		'先開RPC再開NFS',
		'主要設定exports',
		'用root_squash, all_squash, anonuid來管理權限 增加安全性',
		'rpcbind start',
		'showmount',
		'mount -t nfs IP:remote_path local_path',
		'unmount path',
		'mount時加參數如nosuid, noexec, nodev, nouser',

	};
},
{
	['DNS'];
	_介紹 = {
		'UDP',
		'domain name system',
		'是一種服務也是一種協定',
		'由特定軟體提供: 如BIND, DJBDNS',
		'用domain name查ip',
		'recursive (client<->server) / iterative (server<->server)',
		'每一級domain長度的限制是63個字元，domain總長度則不能超過253個字元。',
		'先找root server'
			.'tw的server'
			.'.com.tw的server'
			.'pchome.com.tw的server(我們自己的)'
			.'shopping.gs1.pchome.com.tw'
			.'CNAME: 24h.pchome.com.tw',
		'RCodes: 1:Format Error 2:Server Failure 3:Name Error 4:Not Implemented 5:Refused。',
		'Authoritative DNS server',
		'type A::  name: hostname, value: ip',
		'type NS::  name: domain, value: authoritative server',
		'type CNAME: 別名',
	};
	_使用時機 = {
		'自架: 內網',
		'連自己的domain不需要往外找dns',
		'要立即生效(先不論dns cache)，想調隨時可調',
	};
	_為何要用 = {
		'Load distribution',
		'解析內網的domain',
		'連自己的DNS server就不需要連外網，省時省頻寬。',
		'改自己網站的主機、domain、IP等等的很方便',
		'自己監控自己的dns server',
	};
	_使用方法;
},
{
	['ssh tunnel'];
	_介紹 = {
		'SSH Port Forwarding',
		'把別台主機的port透過ssh掛到本機的port',
		'跳板',
	};
	_為何要用 = {

	};
	_使用時機 = {
		'需要連到防火牆後的server',
		'需要讓內部的服務能被外部使用',
	};
	_使用方法 = {
		'ssh -N -L 0.0.0.0:local-port:target-server:target-port username@proxy-server',
		'lsof -i -n | egrep '\<ssh\>'',
		'-L 本地連遠端 -R 遠端連本地 -D dynamic -N 不要開shell -f 背景執行',
	};
	_其他 = {
		'Port Knocking'
	}
},
{
	['memcached'];
	_介紹 = {
		'一套分散式的高速緩衝記憶體系統',
		'會透過key的hash決定用哪個(memcached)server，可分區 擴展',
		'滿時棄用最久未用',
		'memcached本身不保證data存在',
		'可開多台server給多個client用，也可獨自一台server+client',
		'最好放在安全的網路中',
		'多線程',
		'掛了就G了',
		'LRU',
	};
	_為何要用;
	_使用時機 = {
		'大量請求 / 產生內容成本高',
		'簡單資料型別',
	};
	_使用方法 = {
		'先從memcached取，若無則從DB取並存進memcached',
		'更新DB成功後，從DB取，存進memcached',
		'or 更新DB成功後，直接從memcached刪掉',
		'可加隨機數/字串來讓一批key無效'
	};
},
{
	['Redis'];
	_介紹 = {
		'本質是DB，只是主要in-memory，可備份',
		'可以設定備份、儲存',
		'strings, Lists of strings, Sets of strings, Sorted sets of strings, Hash tables, HyperLogLogs(2.8.9), Stream(5.0), Geospatial data(3.2) 還有其它module可以用' ,
		'RDB快照, journaling(AOF)',
		'single-threaded(or double-threaded)',
		'Clustering(3.0) 變成分散式而且可以備份',
		'master-replica(slave)',
		'WAIT',
		'LRU',
		'因為單thread所以要稍微考慮時間複雜度',
		'slowlog',
		'redis-benchmark',
	};
	_為何要用;
	_使用時機 = {
		'資料持久化和資料同步',
		'session caching, full page cache, message queue applications, leaderboards and counting among others.',
	};
	_使用方法;
},
{
	['RabbitMQ'];
	_介紹 = {
		'Message Queue',
		'AMQP (Advanced Message Queuing Protocol)',
		'Application Intergration',
		'producer -> exchange -> queue -> consumer',
		'direct: RouteKey = queue binding key',
		'fanout: 不看key,輪流發',
		'topic: 寬鬆版的direct',
		'headers: 不看key,以header決定',

	};
	_為何要用 = {
		'decouple publisher & consumer',
		'非同步',
	};
	_使用時機;
	_使用方法;
},
{
	['cdn'];
	_介紹 = {
		'把內容分散到許多位置',
	};
	_為何要用 = {
		'分散占用頻寬',
		'異地備援',
		'使用最近節點降低延遲與錯誤',
		'瀏覽器會限制對單一主機的連線數',
	};
	_使用時機;
	_使用方法 = {
		'花錢: 中華電信,cloudflare之類的',
		'自己架: 讓dns server給client不同的cdn的IP',
	};
},