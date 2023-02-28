import React, { useRef, useState } from "react";
import { Link } from "react-router-dom";
import axiosClient from "../../axios-client";
import { useStateContext } from "../../contexts/ContextProvider";

const Login = () => {
    const usernameRef = useRef();
    const passwordRef = useRef();
    const [errors, setErrors] = useState(null);
    const { setUser, setToken, setRole } = useStateContext();

    const onSubmit = (ev) => {
        ev.preventDefault();

        const payload = {
            username: usernameRef.current.value,
            password: passwordRef.current.value,
        };

        setErrors(null);
        axiosClient
            .post("/login", payload)
            .then(({ data }) => {
                setUser(data.user);
                setRole(data.role);
                setToken(data.token);
            })
            .catch((err) => {
                const response = err.response;
                if (response && response.status == 422) {
                    if (response.data.errors) {
                        setErrors(response.data.errors);
                    } else {
                        setErrors({
                            username: [response.data.message],
                        });
                    }
                }
            });
    };

    return (
        <div className="bg-gray-50 min-h-screen flex items-center justify-center">
            <div className="bg-gray-100 flex shadow-lg p-5">
                <form onSubmit={onSubmit} className="flex flex-col">
                    <img src="" alt="" />
                    <h2 className="text-orange-400 text-3xl font-bold mb-5">
                        Login
                    </h2>
                    {errors && (
                        <div className="bg-red-500 text-white p-2 my-2">
                            {Object.keys(errors).map((key) => (
                                <p key={key}>{errors[key][0]}</p>
                            ))}
                        </div>
                    )}
                    <label htmlFor="">Username</label>
                    <input
                        className="py-2 px-2 mb-3 border border-black w-80"
                        type="text"
                        ref={usernameRef}
                        placeholder="Username"
                    />
                    <label htmlFor="">Password</label>
                    <input
                        className="py-2 px-2 border border-black w-80"
                        type="password"
                        ref={passwordRef}
                        placeholder="Password"
                    />
                    <p className="text-sm mb-3">
                        Forgot Password?{" "}
                        <Link className="text-blue-500" to="forgot-password">
                            Click here
                        </Link>
                    </p>
                    <button className="bg-[#3C67EC] p-3 text-white">
                        Login
                    </button>
                </form>
            </div>
        </div>
    );
};

export default Login;
