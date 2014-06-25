//
//  CourseLogListViewController.m
//  teaching
//
//  Created by kidliuxu on 14-1-24.
//  Copyright (c) 2014年 icesmart. All rights reserved.
//

#import "CourseLogListViewController.h"

@interface CourseLogListViewController ()

@end

@implementation CourseLogListViewController
@synthesize courseUrl;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (id) initWithUrl:(NSURL *) url
{
    if( (self=[self init]))
    {

        self.courseUrl = url;

    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	[self setNavTitle:@"培训记录列表"];
    [self addBackButton];

    [self initWebView];
    NSURLRequest *request =[NSURLRequest requestWithURL:self.courseUrl];
    [self.webView loadRequest:request];
}

-(BOOL) webView:(UIWebView *)webView shouldStartLoadWithRequest:(NSURLRequest *)request navigationType:(UIWebViewNavigationType)navigationType
{


    NSLog(@"request %@",[request URL]);

    if (navigationType == UIWebViewNavigationTypeLinkClicked) {

        NSURL *URL = [request URL];


        NSLog(@"NSURL %@,%@,%@,%@",[URL baseURL],[URL lastPathComponent],[URL parameterString],[URL standardizedURL]);

        NSLog(@"request url :%@",[URL scheme]);

        if ([[URL scheme] isEqualToString:@"http"]) {




            CourseLogsDetailViewController *ctl = [[CourseLogsDetailViewController alloc]initWithUrl:[request URL] ];

            [self.navigationController pushViewController:ctl animated:YES];
            [ctl release];
            
            
        }else{
            
            //Not a URL
            
        }
        
        return NO;
        
    }
    
    return YES;
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
