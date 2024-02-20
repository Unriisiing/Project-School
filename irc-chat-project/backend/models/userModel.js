const mongoose = require("mongoose");

const userSchema = new mongoose.Schema({
  nickname: {
    type: String,
    required: [true, "Please Enter Your Name"],
  },
});

module.exports = mongoose.model("User", userSchema);
