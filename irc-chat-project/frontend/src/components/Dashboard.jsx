import { useEffect, useRef, useState } from "react";
import { initSocket } from "../config/socket";
import { useNavigate } from "react-router-dom";
import { toast } from "react-toastify";
import axios from "axios";
import { FaPlus } from "react-icons/fa";
import { IoTrashBinSharp } from "react-icons/io5";
import { TbDoorExit } from "react-icons/tb";
import { IoMdExit } from "react-icons/io";
import { HiUserGroup } from "react-icons/hi2";
import { FaRegCircleUser } from "react-icons/fa6";

const Dashboard = () => {
  const [nickname, setNickname] = useState("");
  const [channelname, setChannelname] = useState("");
  const [channels, setChannels] = useState([]);

  const scrollRef = useRef();

  const [isshow, setIsshow] = useState(false);

  const [selected, setSelected] = useState({
    type: "",
    name: "",
    createdby: "",
    data: null,
  });
  const navigate = useNavigate();

  const socketRef = useRef(null);
  const [message, setmessage] = useState("");
  const [messages, setmessages] = useState([]);

  const toastOptions = {
    position: "bottom-right",
    autoClose: 5000,
    pauseOnHover: true,
    draggable: true,
    theme: "dark",
  };

  const handleExit = () => {
    setNickname("");
    localStorage.clear();
    navigate("/");
  };

  useEffect(() => {
    const nickname = localStorage.getItem("nickname");
    if (nickname) {
      setNickname(nickname);
    } else {
      navigate("/join");
    }
  }, [nickname]);

  const connectwithSocket = async () => {
    if (socketRef.current?.id) {
      socketRef.current.disconnect();
    }
    socketRef.current = await initSocket();

    socketRef.current.emit("join", {
      nickname: localStorage.getItem("nickname"),
    });
  };

  useEffect(() => {
    axios
      .post("http://localhost:5000/getchannels")
      .then(({ data }) => {
        console.log(data);
        setChannels(data.channels);
      })
      .catch((err) => {
        console.log(err);
      });

    connectwithSocket();

    // return () => {
    //   socketRef?.current?.disconnect();
    // };
  }, []);

  // const handleGetChannels = () => {};

  const handleAddChannel = (name, nickname) => {
    axios
      .post("http://localhost:5000/create", {
        name,
        nickname,
      })
      .then(({ data }) => {
        console.log(data);
        if (data.status === false) {
          toast.error(data.error, toastOptions);
        }
        if (data.status === true) {
          toast.success("Channel Created Successfully", toastOptions);
          setChannels([...channels, data.channel]);
          setChannelname("");
          setIsshow(false);
          setSelected({
            type: 1,
            data: data.channel,
          });
        }
      })
      .catch((err) => {
        // toast.error(data.error, toastOptions);

        console.log(err);
      });
  };

  const handleDeleteChannel = (name, nickname) => {
    // if(selected.data.name)
    axios
      .post("http://localhost:5000/delete", {
        name,
        nickname,
      })
      .then(({ data }) => {
        console.log(data);
        if (data.status === false) {
          toast.error(data.error, toastOptions);
        }
        if (data.status === true) {
          toast.success("Channel Deleted Successfully", toastOptions);
          const newchannels = channels.filter(
            (channel, i) => channel.name !== name
          );
          setSelected({
            type: null,
            data: null,
          });
          setChannels(newchannels);
        }
      })
      .catch((err) => {
        // toast.error(data.error, toastOptions);

        console.log(err);
      });
  };

  const handleJoinChannel = (name, nickname) => {
    socketRef.current.emit("channel:sendalert", {
      nickname,
      channel: name,
      message: `${nickname} joined the channel`,
    });
    axios
      .post("http://localhost:5000/join", {
        name,
        nickname,
      })
      .then(({ data }) => {
        console.log(data);
        if (data.status === false) {
          toast.error(data.error, toastOptions);
        }
        if (data.status === true) {
          toast.success("Channel Joined Successfully", toastOptions);
          const newchannels = channels;

          for (var i in newchannels) {
            if (newchannels[i].name == data.channel.name) {
              newchannels[i].users = data.channel.users;
              break;
            }
          }

          setChannels(newchannels);

          setSelected({
            type: 1,
            data: data.channel,
          });
        }
      })
      .catch((err) => {
        // toast.error(data.error, toastOptions);

        console.log(err);
      });
  };

  const handleQuitChannel = (name, nickname) => {
    axios
      .post("http://localhost:5000/quit", {
        name,
        nickname,
      })
      .then(({ data }) => {
        console.log(data);
        if (data.status === false) {
          toast.error(data.error, toastOptions);
        }
        if (data.status === true) {
          toast.success("Channel Quit Successfully", toastOptions);
          const newchannels = channels;

          for (var i in newchannels) {
            if (newchannels[i].name == data.channel.name) {
              newchannels[i].users = data.channel.users;
              break;
            }
          }

          setChannels(newchannels);

          setSelected({
            type: 1,
            data: data.channel,
          });
        }
      })
      .catch((err) => {
        // toast.error(data.error, toastOptions);

        console.log(err);
      });
  };

  const handleChannelClick = (channel) => {
    setSelected({ type: 1, data: channel });
    setIsshow(false);
    socketRef.current.emit("channel:join", {
      nickname,
      channel: channel.name,
    });
  };

  const addmessage = (type, nickname, channel, message) => {
    console.log(type, nickname, channel, message);

    if (type === 0) {
      const newchat = { type: "Me", fromSelf: true, message };

      setmessages((prev) => [...prev, newchat]);
    } else if (type === 1) {
      const newchat = { type: "Command Response", fromSelf: false, message };

      setmessages((prev) => [...prev, newchat]);
    } else if (type === 2) {
      const newchat = {
        type: `Private message from ${nickname} `,
        fromSelf: false,
        message,
      };

      setmessages((prev) => [...prev, newchat]);
    } else if (type === 3) {
      const newchat = {
        type: `${channel} Channel message from ${nickname} `,
        fromSelf: false,
        message,
      };

      setmessages((prev) => [...prev, newchat]);
    }

    // else if()

    // const newchat = { type, from: nickname, message };
    // setmessages((prev) => [...prev, newchat]);
    // }
  };

  const handleSendMessage = (e) => {
    e.preventDefault();

    addmessage(0, nickname, selected.data?.name, message);

    if (message[0] === "/") {
      console.log("Command execute..");
      const data = message.slice(1);
      const command = data.split(" ");

      switch (command[0]) {
        case "nick":
          console.log("Nickname Command ->", nickname);
          addmessage(
            1,
            nickname,
            selected.data?.name,
            `Nickname: ${nickname} `
          );

          break;
        case "list":
          let channelnames = channels.map((channel) => channel.name);
          let channellist = channelnames;
          if (command[1]) {
            channellist = channelnames.filter((channelname) =>
              channelname.includes(command[1])
            );
          }

          console.log("Channels List -> ", channellist);

          addmessage(
            1,
            nickname,
            selected.data?.name,
            `Channels List : ${channellist} `
          );
          break;
        case "users":
          console.log("Users list -> ", selected.data?.users);
          addmessage(
            1,
            nickname,
            selected.data?.name,
            `Channel users list : ${selected.data?.users} `
          );
          break;
        case "create":
          if (command[1]) {
            handleAddChannel(command[1], nickname);
            console.log("Channel Created Successfully");
            addmessage(
              1,
              nickname,
              selected.data?.name,
              `${command[1]} Channel created Successfully`
            );
          } else {
            console.log("Please enter channel name");
          }
          break;
        case "delete":
          if (command[1]) {
            handleDeleteChannel(command[1], nickname);
            console.log("Channel Deleted Successfully");
            addmessage(
              1,
              nickname,
              selected.data?.name,
              `${command[1]} Channel deleted Successfully`
            );
          } else {
            console.log("Please enter channel name");
          }
          break;
        case "join":
          if (command[1]) {
            handleJoinChannel(command[1], nickname);
            console.log("Channel Joined Successfully");
            addmessage(
              1,
              nickname,
              selected.data?.name,
              `You Joined ${command[1]} Channel Successfully`
            );
          } else {
            console.log("Please enter channel name");
          }
          break;
        case "quit":
          if (command[1]) {
            handleQuitChannel(command[1], nickname);
            console.log("Channel Quit Successfully");
            addmessage(
              1,
              nickname,
              selected.data?.name,
              `You Quit ${command[1]} Channel Successfully`
            );
          } else {
            console.log("Please enter channel name");
          }
          break;
        case "msg":
          if (command[1]) {
            socketRef.current.emit("message:send", {
              from: nickname,
              to: command[1],
              message: command.slice(2).join(" "),
            });
            addmessage(
              1,
              nickname,
              selected.data?.name,
              `Message Sent to ${command[1]} Successfully`
            );
            console.log("Message Send Successfully");
          } else {
            console.log("Please enter channel name");
          }
          break;
        default:
      }
    } else {
      console.log("Normal Channel message");
      const msg = message;

      if (selected.type === 1) {
        // addmessage(0, nickname, selected.data?.name, msg);

        // if(selected.data?users.includes(nickname) ){
        // console.log("true");
        // }
        // else console.log("false")

        if (selected.data?.users.includes(nickname)) {
          socketRef.current.emit("channel:send", {
            nickname,
            channel: selected.data?.name,
            message: msg,
          });
        } else {
          toast.error("Please Join before send message", toastOptions);
        }
      }
    }
    setmessage("");
  };

  const sendmessage = () => {
    socketRef.current.emit("message:send", { nickname, message });
  };

  useEffect(() => {
    if (socketRef.current) {
      socketRef.current.on("joined", ({ nickname }) => {
        console.log(nickname, " Joined a chat ");
      });

      socketRef.current.on("message:recieve", ({ from, message }) => {
        console.log("Chat recieve from ", from, " : ", message);

        addmessage(2, from, selected.data?.name, message);
      });

      socketRef.current.on(
        "channel:recieve",
        ({ nickname, channel, message }) => {
          console.log(
            `Channel : ${channel} - Char recieved from `,
            nickname,
            " : ",
            message
          );

          addmessage(3, nickname, channel, message);

          // addmessage(nickname, channel, message);
        }
      );

      socketRef.current.on(
        "channel:recievealert",
        ({ nickname, channel, message }) => {
          console.log(`Channel Alert : ${channel} - ${message}`);
          // addmessage(user, message);
        }
      );

      socketRef.current.on("disconnected", ({ user, nickname }) => {
        console.log(`${user} disconnected`);
        // addmessage(user, "Disconnect");
      });
    }
  }, [socketRef.current]);

  useEffect(() => {
    scrollRef.current?.scrollIntoView({ behaviour: "smooth" });
  }, [messages]);

  return (
    <div className="flex flex_column h_screen w_screen">
      <div className="header">
        <div className="head">IRC - Chat App</div>
        {nickname && (
          <div className="flex gap_1vmax">
            <div className="flex align_center gap_1vmax px_1vmax profile">
              {" "}
              <FaRegCircleUser />
              {nickname}
            </div>
            <button className="btn" onClick={handleExit}>
              EXIT
            </button>
          </div>
        )}
      </div>
      <div className="dashboard">
        <div className="flex h_full">
          <div className="first_column">
            <div className="flex p_1vmax first_column_top ">
              <div>Channels</div>
              <div
                className="btn"
                onClick={() => {
                  setIsshow(!isshow);
                  setSelected({ type: null, data: null });
                }}
              >
                <FaPlus />
              </div>
            </div>
            <div className="p_1vmax overflow_scroll first_column_second">
              {channels.map((channel, index) => {
                return (
                  <div
                    onClick={() => handleChannelClick(channel)}
                    className={`channel flex justify_between ${
                      channel.name === selected.data?.name && "active_channel"
                    }`}
                  >
                    <div className="flex align_center gap_1vmin">
                      <HiUserGroup />
                      <span>{channel.name} </span>
                    </div>
                    <div className="flex align_center gap_1vmin">
                      {channel.createdby === nickname && (
                        <div
                          onClick={() =>
                            handleDeleteChannel(channel.name, nickname)
                          }
                        >
                          <IoTrashBinSharp />{" "}
                        </div>
                      )}
                      {!channel.users.includes(nickname) && (
                        <div
                          onClick={() =>
                            handleJoinChannel(channel.name, nickname)
                          }
                        >
                          <IoMdExit />
                        </div>
                      )}

                      {channel.users.includes(nickname) &&
                        channel.createdby !== nickname && (
                          <div>
                            <TbDoorExit
                              onClick={() =>
                                handleQuitChannel(channel.name, nickname)
                              }
                            />{" "}
                          </div>
                        )}
                    </div>
                  </div>
                );
              })}
            </div>
          </div>
          <div className="second_column">
            {isshow && (
              <div className="addchannel_form">
                <div>Create New Channel</div>
                <input
                  type="text"
                  value={channelname}
                  onChange={(e) => setChannelname(e.target.value)}
                />

                <button
                  className="btn"
                  onClick={() => handleAddChannel(channelname, nickname)}
                >
                  Create
                </button>
              </div>
            )}
            {selected.type === 1 && (
              <div className="chat_cont">
                <div className="selected_box">
                  <div>IRC - Chat System</div>
                  {/* <div>{selected.data?.name}</div> */}
                  {/* <div className="flex  gap_1vmin">
                    {selected.data?.createdby === nickname && (
                      <button
                        className="btn"
                        onClick={() =>
                          handleDeleteChannel(selected.data?.name, nickname)
                        }
                      >
                        {" "}
                        Delete
                      </button>
                    )}
                    {selected.data?.users.includes(nickname) &&
                      selected.data?.createdby !== nickname && (
                        <button
                          className="btn"
                          onClick={() =>
                            handleQuitChannel(selected.data?.name, nickname)
                          }
                        >
                          {" "}
                          Quit
                        </button>
                      )}
                  </div> */}
                </div>
                {/* {selected.data.users.includes(nickname) ? ( */}
                <>
                  <div className="chat_box">
                    <div className="chat-messages">
                      {messages.map((message, index) => {
                        return (
                          // <div ref={scrollRef} key={uuidv4()}>
                          <div ref={scrollRef} key={index}>
                            <div
                              className={`message ${
                                message.fromSelf ? "sended" : "recieved"
                              }`}
                            >
                              {message.fromSelf ? (
                                <div className="content">
                                  <p>{message.message}</p>
                                </div>
                              ) : (
                                <div className="content">
                                  <div className="chat_type">
                                    {message.type}
                                  </div>
                                  <p>{message.message}</p>
                                </div>
                              )}
                            </div>
                          </div>
                        );
                      })}
                    </div>
                  </div>
                  <div className="flex input_cont">
                    <form className="input_box" onSubmit={handleSendMessage}>
                      <input
                        type="text"
                        onChange={(e) => setmessage(e.target.value)}
                        value={message}
                      />
                      <button>Send</button>
                    </form>
                  </div>
                </>
                {/* ) : (
                  <div className="addchannel_form">
                    {" "}
                    Please Join{" "}
                    <button
                      onClick={() =>
                        handleJoinChannel(selected.data?.name, nickname)
                      }
                      className="btn"
                    >
                      Join
                    </button>
                  </div>
                )} */}
              </div>
            )}

            {!selected.type && !isshow && (
              <div className="welcome">Welcome to IRC</div>
            )}
          </div>
        </div>
      </div>
    </div>
  );
};

export default Dashboard;
