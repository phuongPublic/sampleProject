﻿// Copyright (c) Microsoft Corporation. All rights reserved.
// Licensed under the MIT License.

using Microsoft.Bot.Builder.AI.QnA;
using Microsoft.Extensions.Configuration;

namespace Microsoft.BotBuilderSamples
{
    public class BotServices : IBotServices
    {
        public BotServices(IConfiguration configuration)
        {
            QnAMakerService = new QnAMaker(new QnAMakerEndpoint
            {
                KnowledgeBaseId = configuration["QnAKnowledgebaseId"],
                EndpointKey = configuration["QnAEndpointKey"],
                Host = configuration["QnAEndpointHostName"]
                //Host = GetHostname(configuration)
            });
        }

        public QnAMaker QnAMakerService { get; private set; }

        private string GetHostname(IConfiguration configuration)
        {
            var hostname = configuration["QnAEndpointHostName"];
            if (!hostname.StartsWith("https://"))
            {
                hostname = string.Concat("https://", hostname);
            }
            if (!hostname.EndsWith("/qnamaker"))
            {
                hostname = string.Concat(hostname, "/qnamaker");
            }
            return hostname;
        }
    }
}
