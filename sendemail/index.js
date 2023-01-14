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
            host: process.env.SMTP_HOST,
            port: process.env.SMTP_PORT,
            auth: {
                user: process.env.SMTP_EMAIL_ADDRESS,
                pass: process.env.SMTP_EMAIL_PASSWORD,
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