//
//  CourseLogsDetailViewController.m
//  teaching
//
//  Created by kidliuxu on 14-1-24.
//  Copyright (c) 2014年 icesmart. All rights reserved.
//

#import "CourseLogsDetailViewController.h"

@interface CourseLogsDetailViewController ()

@end

@implementation CourseLogsDetailViewController
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
	// Do any additional setup after loading the view.
    [self setNavTitle:@"培训记录详情"];
    [self addBackButton];

    [self initWebView];
    NSURLRequest *request =[NSURLRequest requestWithURL:self.courseUrl];
    [self.webView loadRequest:request];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
