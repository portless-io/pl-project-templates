const express = require("express");
const nodemailer = require("nodemailer")
require("dotenv").config()

const app = express();
const port = 3000;

app.use(express.json());
app.use(express.urlencoded({ extended: false }));

const SMTP = async (req, res) => {
    try {
        const { from = "automation@microgen.id", to, subject = "Lorem Ipsum", content = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book." } = req.body;
        const mailOptions = {
            from,
            to,
            subject,
            html: content,
        };

        const transporter = nodemailer.createTransport({
            host: "smtp-relay.sendinblue.com",
            port: 587,
            auth: {
                user: "mejik.dev@gmail.com",
                pass: "LQ8cHpkEqPXaAmR1",
            },
        });

        const { response } = await transporter.sendMail(mailOptions);

        return res.status(200).json({ message: response });
    } catch (error) {
        console.log("error log : ", error);
        return res.status(400).json({ error });
    }
};

app.post("/sendEmail", SMTP);

app.listen(port, () => {
    console.log(`Example app listening on port ${port}`)
})