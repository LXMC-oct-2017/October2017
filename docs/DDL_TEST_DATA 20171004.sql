
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

insert into TEAM( TEAM_ID, TEAM_NAME, PASSWORD, STATUS)
           value( 0, 'TEAM 01', MD5('lxmct1'), 0)
               ,( 1, 'TEAM 02', MD5('lxmct2'), 0)
               ,( 2, 'TEAM 03', MD5('lxmct3'), 0)
               ,( 3, 'TEAM 04', MD5('lxmct4'), 0)
               ,( 4, 'TEAM 05', MD5('lxmct5'), 0)
               ,( 5, 'TEAM 06', MD5('lxmct6'), 0)
               ,( 6, 'TEAM 07', MD5('lxmct7'), 0)
               ,( 7, 'TEAM 08', MD5('lxmct8'), 0)
               ,( 8, 'TEAM 09', MD5('lxmct9'), 0)
               ,( 9, 'TEAM 10', MD5('lxmct10'), 0)
               ,(10, 'TEAM 11', MD5('lxmct11'), 0)
               ,(11, 'TEAM 12', MD5('lxmct12'), 0)
               ,(12, 'TEAM 13', MD5('lxmct13'), 0)
               ,(13, 'TEAM 14', MD5('lxmct14'), 0)
               ,(14, 'TEAM 15', MD5('lxmct15'), 0)
               ,(15, 'TEAM 16', MD5('lxmct16'), 0)
               ,(16, 'TEAM 17', MD5('lxmct17'), 0)
               ,(17, 'TEAM 18', MD5('lxmct18'), 0)
               ,(19, 'TEAM 20', MD5('lxmct20'), 0)
               ,(18, 'TEAM 19', MD5('lxmct19'), 0)
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
