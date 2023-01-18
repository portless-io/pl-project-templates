const express = require("express");
const SibApiV3Sdk = require('sib-api-v3-sdk');
require("dotenv").config()

const app = express();
const port = 3000;

app.use(express.json());
app.use(express.urlencoded({ extended: false }));

const SMTP = async (req, res) => {
    try {
        const { from = "automation@microgen.id", to, subject = "Lorem Ipsum", content = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book." } = req.body; 

        const defaultClient = SibApiV3Sdk.ApiClient.instance;
        const apiKey = defaultClient.authentications['api-key'];
        apiKey.apiKey = process.env.SIB_API_KEY;

        const apiInstance = new SibApiV3Sdk.TransactionalEmailsApi();

        const sendSmtpEmail = new SibApiV3Sdk.SendSmtpEmail();

        sendSmtpEmail.to = [{ email: to }];
        sendSmtpEmail.sender = { email: from };
        sendSmtpEmail.htmlContent = content;
        sendSmtpEmail.textContent = content;
        sendSmtpEmail.subject = subject;

        const result = await apiInstance.sendTransacEmail(sendSmtpEmail);

        console.log("email sent to: " + to);

        return res.status(200).json({ message: result });
    } catch (error) {
        console.log("error log : ", error);
        return res.status(400).json({ error });
    }
};

app.post("/sendEmail", SMTP);

app.listen(port, () => {
    console.log(`Example app listening on port ${port}`)
})