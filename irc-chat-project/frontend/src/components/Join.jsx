import styled from "styled-components";
import "react-toastify/dist/ReactToastify.css";
import { toast } from "react-toastify";
import { useState } from "react";
import { useNavigate } from "react-router-dom";

const Join = () => {
  const [nickname, setNickname] = useState("");
  const navigate = useNavigate();

  const toastOptions = {
    position: "bottom-right",
    autoClose: 5000,
    pauseOnHover: true,
    draggable: true,
    theme: "dark",
  };

  const handleSubmit = async (event) => {
    event.preventDefault();

    if (handleValidation()) {
      toast.success(`${nickname} Joined`);
      localStorage.setItem("nickname", nickname);
      navigate("/");
    }
  };

  const handleValidation = () => {
    if (nickname === "") {
      toast.error("Nickname is required", toastOptions);
      return false;
    } else {
      return true;
    }
  };

  return (
    <>
      <FormContainer>
        <form
          onSubmit={(event) => {
            handleSubmit(event);
          }}
        >
          <div className="brand">
            <h1 className="brand_name">Please Enter Nickname</h1>
          </div>

          <input
            id="nickname"
            type="text"
            placeholder="John"
            value={nickname}
            onChange={(e) => {
              setNickname(e.target.value);
            }}
          />

          <button type="submit"> Submit </button>
        </form>
      </FormContainer>
    </>
  );
};

const FormContainer = styled.div`
  height: 100vh;
  width: 100vw;
  background-color: #07070c;

  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: 1vmax;
  font-size: 1vmax;

  .brand {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;

    img {
      height: 3rem;
    }
    h1 {
      color: white;
      text-transform: uppercase;
    }
  }

  form {
    display: flex;
    flex-direction: column;
    gap: 2vmax;
    width: 35%;
    background-color: #0000076;
    padding: 2vmax;
    border-radius: 2rem;

    input {
      background-color: transparent;
      padding: 1vmax;
      border: 0.1rem solid #4e0eff;
      border-radius: 0.4rem;
      color: white;
      width: 100%;
      font-size: 1rem;
      text-align: center;
      &:focus {
        border: 0.1rem solid #997af0;
        outline: none;
      }
    }
    label {
      color: white;
      width: 100%;
      font-size: 1vmax;
      text-align: center;

      div {
        font-size: 1vmax;
        margin-bottom: 1vmax;
      }
    }

    button {
      background-color: #997af0;
      color: white;
      padding: 1vmax;
      border: none;
      font-weight: bold;
      cursor: pointer;
      border-radius: 0.4rem;
      font-size: 1vmax;
      text-transform: uppercase;
      transition: 0.5s ease-in-out;
      // box-shadow: 0px 5px #cab7ff;

      &:hover {
        background-color: #4e3eff;
      }
    }

    span {
      color: white;
      text-transform: uppercase;
      text-align: center;
      a {
        color: #4e8eff;
        text-decoration: none;
        font-weight: bold;
      }
    }
  }

  @media screen and (max-width: 480px) {
    form {
      width: 80%;
    }
  }
`;

export default Join;
