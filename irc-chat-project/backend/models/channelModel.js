const mongoose = require("mongoose");

const channelSchema = new mongoose.Schema({
  name: {
    type: String,
    required: [true, "Please Enter Channel name"],
  },
  users: [],
  createdby: {
    type: String,
    required: [true, "Please send creator name"],
  },
});

module.exports = mongoose.model("Channel", channelSchema);
