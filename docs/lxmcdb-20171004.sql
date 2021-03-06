

/* Create Tables */

CREATE TABLE ANSWER
(
	ANSER_ID VARCHAR(32) NOT NULL COMMENT '回答ID : {TEAM.TEAM_ID}-{DEAL_ID}',
	TEAM_ID INT UNSIGNED NOT NULL COMMENT 'チームID',
	DEAL_ID INT(10) NOT NULL COMMENT 'ディールID : 
',
	PRIMARY KEY (ANSER_ID)
) COMMENT = '回答';


CREATE TABLE DEAL
(
	DEAL_ID INT(10) NOT NULL COMMENT 'DealId : 
',
	DEAL_TITLE VARCHAR(128) NOT NULL COMMENT 'ディールタイトル',
	DEAL_PRICE INT(10) UNSIGNED NOT NULL COMMENT 'ディール価格',
	CATEGORY INT(1) NOT NULL COMMENT 'カテゴリ : 封筒番号',
	PRIMARY KEY (DEAL_ID)
) COMMENT = 'ディールマスタ';


CREATE TABLE ITEM
(
	ITEM_ID INT NOT NULL COMMENT 'ItemId : 0 : Item 1
1 : Item 2',
	ITEM_NAME VARCHAR(32) COMMENT 'アイテム名',
	PASSWORD VARCHAR(32) NOT NULL COMMENT 'アイテム使用パスワード : クイズの答え',
	PRIMARY KEY (ITEM_ID)
) COMMENT = 'アイテムマスタ';


CREATE TABLE ITEM_USE
(
	ITEM_USE_ID INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ItemUseId',
	DEAL_ID INT(10) NOT NULL COMMENT 'DealId : 
',
	ITEM_USE_HISTORY_ID VARCHAR(5) NOT NULL COMMENT 'ItemUseHistoryID : {ITEM_ID(1)}-{TEAM_ID(1-2)}',
	PRIMARY KEY (ITEM_USE_ID)
) COMMENT = 'アイテム使用 : アイテム使用履歴とディールIDの紐づけ';


CREATE TABLE ITEM_USE_HISTORY
(
	ITEM_USE_HISTORY_ID VARCHAR(5) NOT NULL COMMENT 'ItemUseHistoryId : {ITEM_ID(1)}-{TEAM_ID(1-2)}',
	TEAM_ID INT UNSIGNED NOT NULL COMMENT 'チームID',
	ITEM_ID INT NOT NULL COMMENT 'ItemId : 0 : Item 1
1 : Item 2',
	ITEM_USE_RESULT INT NOT NULL COMMENT 'アイテム使用結果 : アイテムを使用した結果',
	PRIMARY KEY (ITEM_USE_HISTORY_ID)
) COMMENT = 'アイテム使用履歴';


CREATE TABLE TEAM
(
	TEAM_ID INT UNSIGNED NOT NULL COMMENT 'チームID',
	TEAM_NAME VARCHAR(32) COMMENT 'チーム名',
	PASSWORD VARCHAR(32) DEFAULT 'password' NOT NULL COMMENT 'パスワード',
	STATUS INT UNSIGNED NOT NULL COMMENT 'ステータス : アイテム使用状況、回答の状態',
	PRIMARY KEY (TEAM_ID)
) COMMENT = 'チームマスタ';



/* Create Foreign Keys */

ALTER TABLE ANSWER
	ADD CONSTRAINT FK_ANSWER_DEAL FOREIGN KEY (DEAL_ID)
	REFERENCES DEAL (DEAL_ID)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE ITEM_USE
	ADD CONSTRAINT FK_ITEM_USE_DEAL FOREIGN KEY (DEAL_ID)
	REFERENCES DEAL (DEAL_ID)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE ITEM_USE_HISTORY
	ADD CONSTRAINT FK_ITEM_USE_HISTORY_ITEM FOREIGN KEY (ITEM_ID)
	REFERENCES ITEM (ITEM_ID)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE ITEM_USE
	ADD CONSTRAINT FK_ITEM_USE_ITEM_USE_HISTORY FOREIGN KEY (ITEM_USE_HISTORY_ID)
	REFERENCES ITEM_USE_HISTORY (ITEM_USE_HISTORY_ID)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE ANSWER
	ADD CONSTRAINT FK_ANSWER_TEAM FOREIGN KEY (TEAM_ID)
	REFERENCES TEAM (TEAM_ID)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE ITEM_USE_HISTORY
	ADD CONSTRAINT FK_ITEM_USE_HISTORY_TEAM FOREIGN KEY (TEAM_ID)
	REFERENCES TEAM (TEAM_ID)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;



