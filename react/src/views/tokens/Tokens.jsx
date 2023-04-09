import React, { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import axiosClient from "../../axios-client";
import { useStateContext } from "../../contexts/ContextProvider";

const Tokens = () => {
    const [tokens, setTokens] = useState([]);
    const [loading, setLoading] = useState(false);
    const { setNotification } = useStateContext();

    const onDelete = async (token) => {
        if (!window.confirm("Are you sure you want to delete this token?")) {
            return;
        }

        await axiosClient.delete(`/tokens/${token.id}`).then(() => {
            setNotification("Token deleted successfuly.");
            getTokens();
        });
    };

    const getTokens = async () => {
        setLoading(true);

        await axiosClient.get("/tokens").then(({ data }) => {
            setLoading(false);
            setTokens(data.data);
        });
    };

    const getClient = async (id) => {
        setLoading(true);

        await axiosClient.get(`/tokens/${id}`).then(({ data }) => {
            setLoading(false);
            console.log(data);
        });
    };

    useEffect(() => {
        getTokens();
    }, []);
    return (
        <>
            <div className="flex flex-row items-center justify-between mb-3">
                <h2 className="font-lg text-2xl">Tokens</h2>
                <Link
                    to="/tokens/create"
                    className="px-3 py-2 text-white bg-green-700"
                >
                    Add New Token
                </Link>
            </div>
            <div className="shadow-md p-3 bg-white">
                <table className="table-auto w-full">
                    <thead className="border border-solid border-l-0 border-r-0">
                        <tr className="bg-[#F8F8F8]">
                            <th className="py-3 text-lg font-normal text-start">
                                ID
                            </th>
                            <th className="py-3 text-lg font-normal text-start">
                                Number
                            </th>
                            <th className="py-3 text-lg font-normal text-start">
                                Client
                            </th>
                            <th className="py-3 text-lg font-normal text-start">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    {loading && (
                        <tbody>
                            <tr>
                                <td colSpan={7} className="text-center">
                                    Loading...
                                </td>
                            </tr>
                        </tbody>
                    )}
                    {!loading && (
                        <tbody>
                            {tokens.map((token) => (
                                <tr key={token.id}>
                                    <td className="py-2">{token.id}</td>
                                    <td className="py-2">{token.number}</td>
                                    <td className="py-2">
                                        {token.client.name}
                                    </td>
                                    <td className="text-sm py-2">
                                        <Link
                                            to={"/tokens/show/" + token.id}
                                            className="bg-blue-300 p-1 text-white"
                                        >
                                            View
                                        </Link>
                                        &nbsp;
                                        <Link
                                            to={"/tokens/" + token.id}
                                            className="bg-green-300 p-1 text-white"
                                        >
                                            Edit
                                        </Link>
                                        &nbsp;
                                        <button
                                            onClick={(ev) => onDelete(token)}
                                            className="bg-red-500 text-white p-1"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    )}
                </table>
            </div>
        </>
    );
};

export default Tokens;
