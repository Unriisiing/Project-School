const express = require("express");
const mongoose = require("mongoose");
const cors = require("cors");
const port = process.env.PORT || 5000;
const { Server, Socket } = require("socket.io");
const app = express();
require("dotenv").config();

const Channel = require("./models/channelModel");

// app.use(
//   "*",
//   cors({
//     origin: process.env.FRONT_URL,
//   })
// );

app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

app.get("/", (req, res) => {
  res.send("Server is running..");
});

app.post("/create", async (req, res, next) => {
  const { name, nickname } = req.body;

  try {
    const ischannel = await Channel.findOne({ name: name });
    console.log(ischannel);
    if (ischannel) {
      return res.status(200).json({
        status: false,
        error: "Channel Already exists! Please enter Different Channel name",
      });
    }

    const channel = await Channel.create({
      name,
      users: [nickname],
      createdby: nickname,
    });

    res.status(200).json({
      status: true,
      channel,
      message: "Channel created Successfully!",
    });
  } catch (error) {
    return res.status(500).json({ error });
  }
});

app.post("/delete", async (req, res, next) => {
  const { name, nickname } = req.body;
  console.log(req.body);
  try {
    const ischannel = await Channel.findOne({ name });
    if (!ischannel) {
      return res
        .status(200)
        .json({ status: false, error: "Channel not exists" });
    }

    console.log(ischannel);
    if (ischannel.createdby !== nickname) {
      return res
        .status(200)
        .json({ status: false, error: "You can not Delete this Channel" });
    }

    await Channel.deleteMany({ name });

    res.status(200).json({ status: true });
  } catch (error) {
    return res.status(500).json({ error });
  }
});

app.post("/join", async (req, res, next) => {
  const { name, nickname } = req.body;
  console.log(req.body);
  try {
    const ischannel = await Channel.findOne({ name });
    if (!ischannel) {
      return res
        .status(200)
        .json({ status: false, error: "Channel not exists" });
    }

    const channel = await Channel.findOneAndUpdate(
      { name },
      {
        $push: {
          users: nickname,
        },
      },
      { returnDocument: "after" }
    );

    res.status(200).json({ status: true, channel });
  } catch (error) {
    return res.status(500).json({ error });
  }
});

app.post("/quit", async (req, res, next) => {
  const { name, nickname } = req.body;
  console.log(req.body);
  try {
    const ischannel = await Channel.findOne({ name });
    if (!ischannel) {
      return res
        .status(200)
        .json({ status: false, error: "Channel not exists" });
    }

    const channel = await Channel.findOneAndUpdate(
      { name },
      {
        $pull: {
          users: nickname,
        },
      },
      { returnDocument: "after" }
    );

    res.status(200).json({ status: true, channel });
  } catch (error) {
    return res.status(500).json({ error });
  }
});

app.post("/getusers", async (req, res, next) => {
  const { name } = req.body;

  try {
    const ischannel = await Channel.find({ name });
    if (!ischannel) {
      return res
        .status(404)
        .json({ status: false, error: "Channel not exists" });
    }

    const channel = await Channel.find({ name });

    res.status(200).json({ status: true, channel });
  } catch (error) {
    return res.status(500).json({ error });
  }
});

app.post("/getchannels", async (req, res, next) => {
  try {
    const channels = await Channel.find();
    res.status(200).json({ status: true, channels });
  } catch (error) {
    return res.status(500).json({ error });
  }
});

const server = app.listen(port, () => {
  console.log(`Serving running at http://localhost:${port}`);
});

// Socket Connection
const io = new Server(server);
const usertoidMap = {};
const idtouserMap = {};

io.on("connection", (socket) => {
  console.log("Socket Connected ", socket.id);

  socket.on("join", ({ nickname }) => {
    usertoidMap[nickname] = socket.id;
    idtouserMap[socket.id] = nickname;
    console.log(socket.id, "->", nickname, " : joined ");
    socket.broadcast.emit("joined", { nickname });
    // socket..emit("joined", { nickname });
  });

  socket.on("message:send", ({ from, to, message }) => {
    console.log("Chat send from ", from, "->", to, " : ", message);
    socket.to(usertoidMap[to]).emit("message:recieve", { from, message });
  });

  socket.on("message:broadcast", ({ nickname, message }) => {
    console.log("Chat broadcast from ", nickname, " : ", message);
    socket.broadcast.emit("message:recieve", { nickname, message });
  });

  // Channel Event

  socket.on("channel:sendalert", ({ nickname, channel, message }) => {
    // socket.join(channel);
    socket.to(channel).emit("channel:recievealert", {
      nickname,
      channel,
      message,
    });
  });

  socket.on("channel:join", ({ nickname, channel }) => {
    socket.join(channel);
  });

  socket.on("channel:send", ({ nickname, channel, message }) => {
    socket.join(channel);
    console.log("channel: send ", nickname, channel);
    socket.to(channel).emit("channel:recieve", {
      nickname,
      channel,
      message,
    });
  });

  socket.on("channel:quit", ({ nickname, room }) => {
    socket.join(room);
    socket.to(room).emit("channel:recieve", {
      message: `${nickname} leaves the channel`,
    });
  });

  socket.on("disconnecting", () => {
    // socket.broadcast.emit("disconnected", {
    //   name: userMap[socket.id],
    // });
    console.log(`${socket.id} disconnected`);

    delete idtouserMap[socket.id];
    console.log(idtouserMap);

    socket.leave();
  });
});

// mongoose connect
mongoose
  .connect(process.env.MONGO_LINK)
  .then(() => {
    console.log("Database connect successfully");
  })
  .catch((err) => {
    console.log(err);
  });
