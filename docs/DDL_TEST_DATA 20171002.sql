
insert into DEAL(DEAL_ID, DEAL_TITLE, DEAL_PRICE, CATEGORY)
           value(100000, '【テスト】テスト00 ディールID：100000', 20000,  0 )
               ,(100001, '【テスト】テスト01 ディールID：100001', 2000,   1 )
               ,(100002, '【テスト】テスト02 ディールID：100002', 300,    2 )
               ,(100003, '【テスト】テスト03 ディールID：100003', 1,      0 )
               ,(100004, '【テスト】テスト04 ディールID：100004', 200200, 1 )
               ,(100005, '【テスト】テスト05 ディールID：100005', 5000,   2 )
               ,(100006, '【テスト】テスト06 ディールID：100006', 2500,   0 )
               ,(100007, '【テスト】テスト07 ディールID：100007', 0,      1 )
               ,(100008, '【テスト】テスト08 ディールID：100008', 9999,   2 )
               ,(100009, '【テスト】テスト09 ディールID：100009', 123456, 0 ) 
               ,(100010, '【テスト】テスト10 ディールID：100010', 100,    2 ) 
;


insert into ITEM(ITEM_ID, ITEM_NAME, PASSWORD) 
           value(0, 'アイテム1','Password1')
               ,(1, 'アイテム2','Password2')
;

insert into ANSWER_STATUS(ANSWER_STATUS_CD, ANSWER_STATUS_NAME)
                    value('THK', '回答未提出')
                        ,('ANS', '回答提出済み')
;


insert into TEAM( TEAM_ID, TEAM_NAME, PASSWORD, ANSWER_STATUS_CD)
           value( 0, 'TEAM 01', 'lxmct1', 'THK')
               ,( 1, 'TEAM 02', 'lxmct2', 'THK')
               ,( 2, 'TEAM 03', 'lxmct3', 'THK')
               ,( 3, 'TEAM 04', 'lxmct4', 'THK')
               ,( 4, 'TEAM 05', 'lxmct5', 'THK')
               ,( 5, 'TEAM 06', 'lxmct6', 'THK')
               ,( 6, 'TEAM 07', 'lxmct7', 'THK')
               ,( 7, 'TEAM 08', 'lxmct8', 'THK')
               ,( 8, 'TEAM 09', 'lxmct9', 'THK')
               ,( 9, 'TEAM 10', 'lxmct10', 'THK')
               ,(10, 'TEAM 11', 'lxmct11', 'THK')
               ,(11, 'TEAM 12', 'lxmct12', 'THK')
               ,(12, 'TEAM 13', 'lxmct13', 'THK')
               ,(13, 'TEAM 14', 'lxmct14', 'THK')
               ,(14, 'TEAM 15', 'lxmct15', 'THK')
               ,(15, 'TEAM 16', 'lxmct16', 'THK')
               ,(16, 'TEAM 17', 'lxmct17', 'THK')
               ,(17, 'TEAM 18', 'lxmct18', 'THK')
               ,(18, 'TEAM 19', 'lxmct19', 'THK')
               ,(19, 'TEAM 20', 'lxmct20', 'THK')
;

insert into ITEM_USE_HISTORY(ITEM_USE_HISTORY_ID, TEAM_ID, ITEM_ID, ITEM_USE_RESULT)
                       value('0-0', 0, 0, 20000)
                           ,('1-0', 0, 1, -10000)
                           ,('0-1', 1, 0, 5000)
                           ,('0-2', 2, 0, 10000)
;

insert into ITEM_USE(DEAL_ID, ITEM_USE_HISTORY_ID)
               value(100000, '0-0')
                   ,(100010, '1-0')
                   ,(100002, '1-0')
                   ,(100010, '0-1')
                   ,(100002, '0-2')
;
