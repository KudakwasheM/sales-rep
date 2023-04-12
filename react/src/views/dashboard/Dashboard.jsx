import React, { useEffect, useState } from "react";
import axiosClient from "../../axios-client";
import BarChart from "../../components/BarChart";
import { Bar, Line } from "react-chartjs-2";

const Dashboard = () => {
    const [counts, setCounts] = useState([]);
    const [clientsData, setClientsData] = useState([]);
    const [paymentsData, setPaymentsData] = useState([]);
    const [weekRevenueData, setWeekRevenueData] = useState([]);
    const [lastRevenueData, setLastRevenueData] = useState([]);

    const getCounts = async () => {
        await axiosClient.get("/counts").then(({ data }) => {
            setCounts(data);
        });
    };

    const getClientsData = async () => {
        await axiosClient.get("/counts/clients/comparison").then(({ data }) => {
            setClientsData(data);
        });
    };

    const getPaymentsData = async () => {
        await axiosClient
            .get("/counts/payments/comparison")
            .then(({ data }) => {
                setPaymentsData(data);
            });
    };

    const getRevenueData = async () => {
        await axiosClient.get("/counts/revenue/comparison").then(({ data }) => {
            console.log(data.thisWeek);
            setWeekRevenueData(data.thisWeek);
            setLastRevenueData(data.lastWeek);
        });
    };

    useEffect(() => {
        getCounts();
        getClientsData();
        getPaymentsData();
        getRevenueData();
    }, []);

    return (
        <div className="w-full p-8 mx-auto">
            {/* <!-- row 1 --> */}
            <div className="flex flex-wrap -mx-3 mb-6">
                {/* <!-- card1 --> */}
                <div className="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                    <div className="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border-2 border-orange-100">
                        <div className="flex-auto p-4">
                            <div className="flex flex-row -mx-3">
                                <div className="flex-none w-2/3 max-w-full px-3">
                                    <div>
                                        <p className="mb-0 font-sans font-semibold leading-normal text-sm italic">
                                            Total Revenue
                                        </p>
                                        <h5 className="mb-0 font-bold text-2xl">
                                            $ {counts.revenue}
                                        </h5>
                                    </div>
                                </div>
                                <div className="px-3 text-right basis-1/3">
                                    {/* <div className="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500"> */}
                                    <div className="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-orange-300 to-orange-500">
                                        <i className="ni leading-none ni-money-coins text-lg relative top-3.5 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* <!-- card2 --> */}
                <div className="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                    <div className="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border-2 border-orange-100">
                        <div className="flex-auto p-4">
                            <div className="flex flex-row -mx-3">
                                <div className="flex-none w-2/3 max-w-full px-3">
                                    <div>
                                        <p className="mb-0 font-sans font-semibold leading-normal text-sm italic">
                                            Users
                                        </p>
                                        <h5 className="mb-0 font-bold text-2xl">
                                            {counts.usersCount}
                                        </h5>
                                    </div>
                                </div>
                                <div className="px-3 text-right basis-1/3">
                                    {/* <div className="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500"> */}
                                    <div className="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-orange-300 to-orange-500">
                                        <i className="ni leading-none ni-world text-lg relative top-3.5 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* <!-- card3 --> */}
                <div className="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                    <div className="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border-2 border-orange-100">
                        <div className="flex-auto p-4">
                            <div className="flex flex-row -mx-3">
                                <div className="flex-none w-2/3 max-w-full px-3">
                                    <div>
                                        <p className="mb-0 font-sans font-semibold leading-normal text-sm italic">
                                            Clients
                                        </p>
                                        <h5 className="mb-0 font-bold text-2xl">
                                            {counts.clientsCount}
                                        </h5>
                                    </div>
                                </div>
                                <div className="px-3 text-right basis-1/3">
                                    {/* <div className="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500"> */}
                                    <div className="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-orange-300 to-orange-500">
                                        <i className="ni leading-none ni-paper-diploma text-lg relative top-3.5 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* <!-- card4 --> */}
                <div className="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4 ">
                    <div className="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border-2 border-orange-100">
                        <div className="flex-auto p-4">
                            <div className="flex flex-row -mx-3">
                                <div className="flex-none w-2/3 max-w-full px-3">
                                    <div>
                                        <p className="mb-0 font-sans font-semibold leading-normal text-sm italic">
                                            Tokens Issued
                                        </p>
                                        <h5 className="mb-0 font-bold text-2xl">
                                            {counts.tokensCount}
                                        </h5>
                                    </div>
                                </div>
                                <div className="px-3 text-right basis-1/3">
                                    {/* <div className="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500"> */}
                                    <div className="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-orange-300 to-orange-500">
                                        <i className="ni leading-none ni-cart text-lg relative top-3.5 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div className="grid grid-cols-2 mb-3 gap-4">
                <div className="bg-white p-3 border-2 border-orange-100 rounded-xl">
                    <Bar
                        className="mb-3"
                        data={{
                            labels: Object.keys(clientsData),
                            datasets: [
                                {
                                    label: "Clients Added Over 5 Weeks",
                                    data: Object.values(clientsData),
                                },
                            ],
                        }}
                    />
                </div>
                <div className="bg-white p-3 border-2 border-orange-100 rounded-xl">
                    <Bar
                        data={{
                            labels: Object.keys(paymentsData),
                            datasets: [
                                {
                                    label: "Payments Revenue Over 5 Weeks",
                                    data: Object.values(paymentsData),
                                },
                            ],
                        }}
                        options={{}}
                    />
                </div>
            </div>
            <div className="bg-white p-3 border-2 border-orange-100 rounded-xl mb-3">
                <Line
                    data={{
                        labels: Object.keys(weekRevenueData),
                        datasets: [
                            {
                                label: "Current Week",
                                data: Object.values(weekRevenueData),
                                //     borderColor: Utils.CHART_COLORS.red,
                                //     backgroundColor: Utils.transparentize(
                                //         Utils.CHART_COLORS.red,
                                //         0.5
                                //     ),
                            },
                            {
                                label: "Last Week",
                                data: Object.values(lastRevenueData),
                                //     borderColor: Utils.CHART_COLORS.blue,
                                //     backgroundColor: Utils.transparentize(
                                //         Utils.CHART_COLORS.blue,
                                //         0.5
                                //     ),
                            },
                        ],
                    }}
                    options={{
                        tension: 0.4,
                        title: {
                            text: "Revenue Comaprison Graph",
                        },
                    }}
                />
            </div>
        </div>
    );
};

export default Dashboard;
