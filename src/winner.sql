SELECT id, nickname, twitter_account, instagram_account
FROM participations
WHERE email_address <> 'montyclt@outlook.com' -- Exclude non-participants donnors
ORDER BY RAND()
LIMIT 5; -- If first winner decline the prize
