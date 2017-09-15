
insert into DEAL(DEAL_ID, DEAL_TITLE, DEAL_PRICE)
           value(100000, '【テスト】テスト00 ディールID：100000', 20000)
               ,(100001, '【テスト】テスト01 ディールID：100001', 2000)
               ,(100002, '【テスト】テスト02 ディールID：100002', 300)
               ,(100003, '【テスト】テスト03 ディールID：100003', 1)
               ,(100004, '【テスト】テスト04 ディールID：100004', 200200)
               ,(100005, '【テスト】テスト05 ディールID：100005', 5000)
               ,(100006, '【テスト】テスト06 ディールID：100006', 2500)
               ,(100007, '【テスト】テスト07 ディールID：100007', 0)
               ,(100008, '【テスト】テスト08 ディールID：100008', 9999)
               ,(100009, '【テスト】テスト09 ディールID：100009', 123456)
               ,(100010, '【テスト】テスト10 ディールID：100010', 100)
;


insert into ITEM(ITEM_ID) 
           value(0)
               ,(1)
;

insert into ANSWER_STATUS(ANSWER_STATUS_CD, ANSWER_STATUS_NAME)
                    value('THK', '回答未提出')
                        ,('ANS', '回答提出済み')
;


insert into TEAM( TEAM_ID, TEAM_NAME, ANSWER_STATUS_CD)
           value( 0, 'TEAM 01', 'THK')
               ,( 1, 'TEAM 02', 'THK')
               ,( 2, 'TEAM 03', 'THK')
               ,( 3, 'TEAM 04', 'THK')
               ,( 4, 'TEAM 05', 'THK')
               ,( 5, 'TEAM 06', 'THK')
               ,( 6, 'TEAM 07', 'THK')
               ,( 7, 'TEAM 08', 'THK')
               ,( 8, 'TEAM 09', 'THK')
               ,( 9, 'TEAM 10', 'THK')
               ,(10, 'TEAM 11', 'THK')
               ,(11, 'TEAM 12', 'THK')
               ,(12, 'TEAM 13', 'THK')
               ,(13, 'TEAM 14', 'THK')
               ,(14, 'TEAM 15', 'THK')
               ,(15, 'TEAM 16', 'THK')
               ,(16, 'TEAM 17', 'THK')
               ,(17, 'TEAM 18', 'THK')
               ,(18, 'TEAM 19', 'THK')
               ,(19, 'TEAM 20', 'THK')
;

insert into ITEM_USE_HISTORY(TEAM_ID, ITEM_ID, ITEM_USE_RESULT)
                       value(1, 0, 20000)
                           ,(1, 1, -10000)
                           ,(2, 0, 5000)
                           ,(3, 1, 10000)
;

insert into ITEM_USE(DEAL_ID, ITEM_USE_HISTORY_ID)
               value(100000, 1)
                   ,(100010, 2)
				   ,(100002, 2)
                   ,(100010, 3)
                   ,(100002, 4)
;
