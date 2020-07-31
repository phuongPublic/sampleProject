# AI Helpdesk Chatbot

-------------------------------------------------------

## サービスの紹介

### チャットボット設計
* チャットボットの流れ
<img width="100%" alt="bot-flow" src="https://user-images.githubusercontent.com/58759076/89002049-0c39d480-d337-11ea-908b-ef0de7101e4b.png">

1. 従業員がFAQボットにアクセスします。

2. Azure Active Director が従業員の身元を確認します。

3. 問い合わせの意図を理解するために、問い合わせはLUISモデルに
送信されます。

4. 意図に基づいて、問い合わせは適切なナレッジベースに転送され、
QnA Maker が問い合わせに最もよくマッチした回答を返します。

5. 問い合わせの結果が従業員に表示されます。

6. ユーザートラフィックからのフィードバックに基づいて QnA ナレッジベースを
管理および更新します。

* トレーニングの流れ
<img src="https://user-images.githubusercontent.com/58759076/89002719-cda51980-d338-11ea-8b47-d7f990dc801b.png" width="100%" title="training-flow" alt="flow chart 2"></img>


### 事前準備
* [Install](https://visualstudio.microsoft.com/) Visual Studio 2019 including ASP.NET, 
* [Install](https://marketplace.visualstudio.com/items?itemName=BotBuilder.botbuilderv4) Bot Framework v4 SDK Templates for Visual Studio 
* [Install](https://github.com/microsoft/BotFramework-Emulator) Bot Framework emulator 
* [Create](https://www.qnamaker.ai/) QnA Maker service 
* [Create](https://www.luis.ai/) Language Understanding (LUIS)


* [Get](https://azure.microsoft.com/free/) Azure Trial Account 
QnA Maker service

### Azureリソース
* [azure portal](https://portal.azure.com/) 
#### Web App bot 
*ウェブチェトボトリソースの作成
1.リソースグループを作成する
2.リソースの作成>「Web App Bot」を選択
      
